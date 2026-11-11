<?php

namespace Vendor\Cms\Support\Traductions;

/**
 * Repérage et remplacement des textes d'une page (sites multilingues,
 * étape 2 — docs/CONCEPTION-MULTILINGUE.md côté admin).
 *
 * ⚠ Classe présente en DOUBLE : admin (étiquetage à l'enregistrement) et front
 * (remplacement au rendu). Toute modification se reporte dans les deux projets.
 *
 * POURQUOI UN ANALYSEUR MAISON, ET PAS DOMDocument
 * DOMDocument réécrit tout le document (entités, attributs sans valeur,
 * balises HTML5, scripts en ligne, <template>…) : réenregistrer un gabarit
 * passé par lui l'abîme en silence. Ici, le HTML est seulement LU ; les
 * modifications sont des insertions à des positions précises, et chaque octet
 * qui n'est pas concerné reste identique.
 *
 * Étiquettes posées :
 *   data-gx-t="p12-3fa9c1"   bloc de texte (contenu entier, mise en forme comprise)
 *   data-gx-ta="p12-77b0e2"  attributs traduisibles (alt, title, placeholder,
 *                            aria-label, value d'un bouton) → clés « k@alt »…
 *
 * Clé = préfixe du propriétaire (p{page}, r{région}) + empreinte courte du
 * texte au moment de l'étiquetage. Une étiquette existante et valide est
 * gardée telle quelle (le texte peut changer : la traduction passe alors « à
 * revoir ») ; une étiquette d'un autre propriétaire (section copiée d'une autre
 * page) ou en double (section dupliquée) est remplacée.
 */
final class TextesHtml
{
    /** Éléments « en ligne » : un bloc de texte peut en contenir. */
    private const EN_LIGNE = [
        'a', 'abbr', 'b', 'bdi', 'bdo', 'br', 'cite', 'data', 'del', 'dfn', 'em', 'font', 'i', 'img',
        'ins', 'kbd', 'mark', 'q', 's', 'samp', 'small', 'span', 'strike', 'strong', 'sub', 'sup',
        'time', 'u', 'var', 'wbr',
    ];

    /** Sous-arbres jamais traduits. */
    private const EXCLUS = [
        'script', 'style', 'noscript', 'template', 'svg', 'math', 'iframe', 'canvas', 'video', 'audio',
        'object', 'code', 'pre', 'textarea', 'head', 'title',
    ];

    /** Éléments vides (sans balise fermante). */
    private const VIDES = [
        'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source',
        'track', 'wbr',
    ];

    /** Contenu brut : lu jusqu'à la balise fermante, sans analyse. */
    private const BRUTS = ['script', 'style', 'textarea', 'title', 'xmp', 'noscript', 'template', 'svg'];

    /** Attributs traduisibles. */
    public const ATTRIBUTS = ['alt', 'title', 'placeholder', 'aria-label', 'value'];

    /**
     * Blocs remplis au rendu par le serveur (produits, articles, réglages…) :
     * leurs textes viennent de leurs tables (étape 5), pas de la page.
     */
    private const DYNAMIQUES = '/^data-gx-(bind|products|categories|stat|stats|activities|posts|forfaits|nearby|langues|dest|dest-chain|gallery|galleries)$/i';

    /* ─────────────────────────────── Étiquetage ─────────────────────────────── */

    /**
     * Pose les étiquettes.
     *
     * @return array{html: string, sources: array<string, string>}
     *         sources : clé → texte source (HTML intérieur, ou valeur d'attribut
     *         pour « clé@attribut »), pour l'empreinte et l'écran Traductions.
     */
    public static function etiqueter(string $html, string $prefixe, array $reprise = []): array
    {
        $arbre = self::analyser($html);
        $editions = [];
        $sources = [];
        $utilisees = [];

        $valide = static fn (?string $cle) => $cle !== null
            && preg_match('/^' . preg_quote($prefixe, '/') . '-[a-z0-9]+(?:-\d+)?$/', $cle);

        $nouvelle = static function (string $base) use ($prefixe, &$utilisees): string {
            $cle = $prefixe . '-' . substr(sha1($base), 0, 6);
            $n = 2;
            $essai = $cle;
            while (isset($utilisees[$essai])) {
                $essai = $cle . '-' . $n++;
            }

            return $essai;
        };

        // 1er passage : les étiquettes valides déjà en place sont réservées
        // dans l'ordre du document (la première occurrence garde la sienne).
        $reservees = [];
        self::parcourir($arbre, static function (array $n) use (&$reservees, $valide) {
            foreach (['data-gx-t', 'data-gx-ta'] as $a) {
                $cle = $n['attrs'][$a] ?? null;
                if ($valide($cle) && ! isset($reservees[$a][$cle])) {
                    $reservees[$a][$cle] = $n['debut'];
                }
            }
        });
        foreach ($reservees as $liste) {
            foreach ($liste as $cle => $_) {
                $utilisees[$cle] = true;
            }
        }

        /* 2e passage : relevé des blocs et attributs à étiqueter, sans encore
           choisir les clés manquantes (la reprise doit voir tout le document
           avant d'attribuer quoi que ce soit). */
        $noeuds = [];    // debut => [noeud, demande T, demande A]
        $demandes = [];  // [debut, 't'|'a', texte normalisé, chemin, base de l'empreinte]
        $traiter = function (array $n, bool $dansBloc, string $chemin) use (&$traiter, &$editions, &$noeuds, &$demandes, &$sources, $reservees, $html) {
            if (self::estExclu($n)) {
                // Étiquette égarée dans un bloc exclu : retirée.
                if (isset($n['attrs']['data-gx-t']) || isset($n['attrs']['data-gx-ta'])) {
                    $editions[] = self::editionOuvrante($html, $n, null, null);
                }

                return;
            }

            $estBloc = ! $dansBloc && self::estBlocTexte($n);
            $noeuds[$n['debut']] = ['n' => $n, 't' => null, 'a' => null, 'valeurs' => [], 'interieur' => null];

            if ($estBloc) {
                $interieur = substr($html, $n['finOuvrante'], $n['finContenu'] - $n['finOuvrante']);
                $noeuds[$n['debut']]['interieur'] = trim($interieur);
                $actuelle = $n['attrs']['data-gx-t'] ?? null;
                if ($actuelle !== null && ($reservees['data-gx-t'][$actuelle] ?? null) === $n['debut']) {
                    $noeuds[$n['debut']]['t'] = $actuelle;
                } else {
                    $norme = self::normaliser($interieur);
                    $demandes[] = [$n['debut'], 't', $norme, $chemin, $norme, trim($interieur)];
                }
            }

            $valeurs = self::attributsTraduisibles($n);
            if ($valeurs) {
                $noeuds[$n['debut']]['valeurs'] = $valeurs;
                $actuelle = $n['attrs']['data-gx-ta'] ?? null;
                if ($actuelle !== null && ($reservees['data-gx-ta'][$actuelle] ?? null) === $n['debut']) {
                    $noeuds[$n['debut']]['a'] = $actuelle;
                } else {
                    $joint = self::normaliser(implode('|', $valeurs));
                    $demandes[] = [$n['debut'], 'a', $joint, $chemin, implode('|', $valeurs) . '@', null];
                }
            }

            $rang = [];
            foreach ($n['enfants'] as $enfant) {
                if (isset($enfant['nom'])) {
                    $rang[$enfant['nom']] = ($rang[$enfant['nom']] ?? -1) + 1;
                    $traiter($enfant, $dansBloc || $estBloc, $chemin . '/' . $enfant['nom'] . '[' . $rang[$enfant['nom']] . ']');
                }
            }
        };

        $rang = [];
        foreach ($arbre as $n) {
            if (isset($n['nom'])) {
                $rang[$n['nom']] = ($rang[$n['nom']] ?? -1) + 1;
                $traiter($n, false, $n['nom'] . '[' . $rang[$n['nom']] . ']');
            }
        }

        /* 3e passage : clés des demandes. Avec une REPRISE (contenu précédent
           de la même page, avant une mise à jour de gabarit) :
             a) même texte qu'avant → même clé : la traduction suit ;
             b) sinon, même place qu'avant → même clé : la traduction reste,
                « à revoir » puisque le texte a changé ;
             c) sinon, nouvelle clé. */
        $cles = [];
        $libre = static function (?string $c) use (&$utilisees, $valide): bool {
            return $c !== null && $valide($c) && ! isset($utilisees[$c]);
        };
        if ($reprise) {
            foreach ($demandes as $i => [, $type, $norme]) {
                foreach ($reprise[$type === 't' ? 'textes' : 'attributs'][$norme] ?? [] as $c) {
                    if ($libre($c)) {
                        $cles[$i] = $c;
                        $utilisees[$c] = true;
                        break;
                    }
                }
            }
            foreach ($demandes as $i => [, $type, , $chemin]) {
                $c = $reprise[$type === 't' ? 'chemins' : 'cheminsAttributs'][$chemin] ?? null;
                if (! isset($cles[$i]) && $libre($c)) {
                    $cles[$i] = $c;
                    $utilisees[$c] = true;
                }
            }
        }
        foreach ($demandes as $i => [$debut, $type, , , $base]) {
            $c = $cles[$i] ?? $nouvelle($base);
            $utilisees[$c] = true;
            $noeuds[$debut][$type] = $c;
        }

        // Éditions des balises ouvrantes, et sources dans l'ordre du document.
        foreach ($noeuds as $info) {
            $n = $info['n'];
            if ($info['t'] !== null) {
                $sources[$info['t']] = $info['interieur'];
            }
            foreach ($info['valeurs'] as $nom => $valeur) {
                $sources[$info['a'] . '@' . $nom] = $valeur;
            }
            if (($n['attrs']['data-gx-t'] ?? null) !== $info['t'] || ($n['attrs']['data-gx-ta'] ?? null) !== $info['a']) {
                $editions[] = self::editionOuvrante($html, $n, $info['t'], $info['a']);
            }
        }

        return ['html' => self::appliquerEditions($html, $editions), 'sources' => $sources];
    }

    /**
     * Repères d'un HTML déjà étiqueté, pour reprendre ses clés dans un
     * nouveau contenu de la même page (mise à jour de gabarit) : texte
     * normalisé → clés, et place dans le document → clé.
     *
     * @return array{textes: array<string, string[]>, chemins: array<string, string>,
     *               attributs: array<string, string[]>, cheminsAttributs: array<string, string>}
     */
    public static function reperes(string $html): array
    {
        $reperes = ['textes' => [], 'chemins' => [], 'attributs' => [], 'cheminsAttributs' => []];

        $visiter = function (array $noeuds, string $parent) use (&$visiter, &$reperes, $html) {
            $rang = [];
            foreach ($noeuds as $n) {
                if (! isset($n['nom'])) {
                    continue;
                }
                $rang[$n['nom']] = ($rang[$n['nom']] ?? -1) + 1;
                $chemin = ($parent === '' ? '' : $parent . '/') . $n['nom'] . '[' . $rang[$n['nom']] . ']';

                if (($cle = $n['attrs']['data-gx-t'] ?? null) !== null && $n['finContenu'] !== null) {
                    $reperes['textes'][self::normaliser(substr($html, $n['finOuvrante'], $n['finContenu'] - $n['finOuvrante']))][] = $cle;
                    $reperes['chemins'][$chemin] ??= $cle;
                }
                if (($cle = $n['attrs']['data-gx-ta'] ?? null) !== null) {
                    $reperes['attributs'][self::normaliser(implode('|', self::attributsTraduisibles($n)))][] = $cle;
                    $reperes['cheminsAttributs'][$chemin] ??= $cle;
                }
                if ($n['enfants']) {
                    $visiter($n['enfants'], $chemin);
                }
            }
        };
        $visiter(self::analyser($html), '');

        return $reperes;
    }

    /**
     * Textes sources d'un HTML déjà étiqueté (clé → texte), sans le modifier.
     *
     * @return array<string, string>
     */
    public static function sources(string $html): array
    {
        $sources = [];
        self::parcourir(self::analyser($html), static function (array $n) use ($html, &$sources) {
            if (($cle = $n['attrs']['data-gx-t'] ?? null) !== null && $n['finContenu'] !== null) {
                $sources[$cle] = trim(substr($html, $n['finOuvrante'], $n['finContenu'] - $n['finOuvrante']));
            }
            if (($cle = $n['attrs']['data-gx-ta'] ?? null) !== null) {
                foreach (self::attributsTraduisibles($n) as $nom => $valeur) {
                    $sources[$cle . '@' . $nom] = $valeur;
                }
            }
        });

        return $sources;
    }

    /** Clés présentes dans un HTML (recherche rapide, sans analyse). */
    public static function cles(string $html): array
    {
        if (! preg_match_all('/\sdata-gx-ta?\s*=\s*["\']([A-Za-z0-9\-]+)["\']/', $html, $m)) {
            return [];
        }

        return array_values(array_unique($m[1]));
    }

    /** Empreinte d'un texte source (espaces normalisés). */
    public static function empreinte(string $texte): string
    {
        return sha1(self::normaliser($texte));
    }

    /* ─────────────────────────────── Remplacement ─────────────────────────────── */

    /**
     * Remplace les textes étiquetés par leur traduction.
     * Une clé sans traduction garde le texte principal (jamais de vide).
     *
     * @param  array<string, string>  $traductions  clé → texte (HTML de mise en
     *                                              forme) ; « clé@attribut » → valeur
     */
    public static function appliquer(string $html, array $traductions): string
    {
        if (! $traductions) {
            return $html;
        }

        $editions = [];
        self::parcourir(self::analyser($html), static function (array $n) use ($html, $traductions, &$editions) {
            $cle = $n['attrs']['data-gx-t'] ?? null;
            if ($cle !== null && $n['finContenu'] !== null && isset($traductions[$cle]) && trim($traductions[$cle]) !== '') {
                $editions[] = [$n['finOuvrante'], $n['finContenu'] - $n['finOuvrante'], $traductions[$cle]];
            }

            $cleA = $n['attrs']['data-gx-ta'] ?? null;
            if ($cleA !== null) {
                $ouvrante = substr($html, $n['debut'], $n['finOuvrante'] - $n['debut']);
                $nouvelle = $ouvrante;
                foreach (self::ATTRIBUTS as $nom) {
                    $valeur = $traductions[$cleA . '@' . $nom] ?? null;
                    if ($valeur === null || trim($valeur) === '' || ! array_key_exists($nom, $n['attrs'])) {
                        continue;
                    }
                    $nouvelle = self::remplacerAttribut($nouvelle, $nom, $valeur);
                }
                if ($nouvelle !== $ouvrante) {
                    $editions[] = [$n['debut'], strlen($ouvrante), $nouvelle];
                }
            }
        });

        return self::appliquerEditions($html, $editions);
    }

    /**
     * Pose `data-gx-t-etat="…"` sur les blocs étiquetés (mode langue de
     * l'éditeur : textes non traduits en orange). N'est JAMAIS enregistré :
     * les enregistrements de page refusent un contenu qui porte ce repère.
     *
     * @param  array<string, string>  $etats  clé → état (manquant, a_revoir, auto, relue)
     */
    public static function marquer(string $html, array $etats): string
    {
        if (! $etats) {
            return $html;
        }

        $editions = [];
        self::parcourir(self::analyser($html), static function (array $n) use ($html, $etats, &$editions) {
            $cle = $n['attrs']['data-gx-t'] ?? null;
            if ($cle === null || ! isset($etats[$cle])) {
                return;
            }
            $ouvrante = substr($html, $n['debut'], $n['finOuvrante'] - $n['debut']);
            $nouvelle = preg_replace('#\s+data-gx-t-etat\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)#i', '', $ouvrante);
            $ajout = ' data-gx-t-etat="' . preg_replace('/[^a-z_]/', '', $etats[$cle]) . '"';
            $nouvelle = preg_match('#(\s*)/>$#', $nouvelle, $fin)
                ? substr($nouvelle, 0, -strlen($fin[0])) . $ajout . $fin[0]
                : substr($nouvelle, 0, -1) . $ajout . '>';
            $editions[] = [$n['debut'], strlen($ouvrante), $nouvelle];
        });

        return self::appliquerEditions($html, $editions);
    }

    /* ─────────────────────────────── Analyse ─────────────────────────────── */

    /**
     * Arbre du document. Nœud élément : nom, attrs, debut (« < »), finOuvrante
     * (après « > »), finContenu (« < » de la balise fermante, null si vide),
     * enfants. Nœud texte : texte.
     */
    private static function analyser(string $html): array
    {
        $racine = ['enfants' => []];
        $pile = [&$racine];
        $longueur = strlen($html);
        $pos = 0;

        $ajouterTexte = static function (int $de, int $a) use (&$pile, $html) {
            if ($a > $de) {
                $parent = &$pile[count($pile) - 1];
                $parent['enfants'][] = ['texte' => substr($html, $de, $a - $de)];
            }
        };

        while ($pos < $longueur) {
            $lt = strpos($html, '<', $pos);
            if ($lt === false) {
                $ajouterTexte($pos, $longueur);
                break;
            }
            $ajouterTexte($pos, $lt);

            // Commentaire
            if (substr($html, $lt, 4) === '<!--') {
                $fin = strpos($html, '-->', $lt + 4);
                $pos = $fin === false ? $longueur : $fin + 3;
                continue;
            }
            // Doctype, <![CDATA[, <?xml
            if (isset($html[$lt + 1]) && ($html[$lt + 1] === '!' || $html[$lt + 1] === '?')) {
                $fin = strpos($html, '>', $lt);
                $pos = $fin === false ? $longueur : $fin + 1;
                continue;
            }
            // Balise fermante
            if (preg_match('#\G</([a-zA-Z][\w:\-]*)\s*>#', $html, $m, 0, $lt)) {
                $nom = strtolower($m[1]);
                for ($i = count($pile) - 1; $i >= 1; $i--) {
                    if ($pile[$i]['nom'] === $nom) {
                        // Ferme aussi les éléments restés ouverts au-dessus.
                        for ($j = count($pile) - 1; $j >= $i; $j--) {
                            $pile[$j]['finContenu'] = $lt;
                            array_pop($pile);
                        }
                        break;
                    }
                }
                $pos = $lt + strlen($m[0]);
                continue;
            }
            // Balise ouvrante
            if (preg_match('#\G<([a-zA-Z][\w:\-]*)((?:\s+[^\s"\'>/=]+(?:\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s"\'=<>`]+))?)*)\s*(/?)>#', $html, $m, 0, $lt)) {
                $nom = strtolower($m[1]);
                $noeud = [
                    'nom' => $nom,
                    'attrs' => self::lireAttributs($m[2]),
                    'debut' => $lt,
                    'finOuvrante' => $lt + strlen($m[0]),
                    'finContenu' => null,
                    'enfants' => [],
                ];
                $pos = $noeud['finOuvrante'];
                $parent = &$pile[count($pile) - 1];

                if (in_array($nom, self::VIDES, true) || $m[3] === '/') {
                    $parent['enfants'][] = $noeud;
                    unset($parent);
                    continue;
                }

                if (in_array($nom, self::BRUTS, true)) {
                    if (preg_match('#</' . preg_quote($nom, '#') . '\s*>#i', $html, $f, PREG_OFFSET_CAPTURE, $pos)) {
                        $noeud['finContenu'] = $f[0][1];
                        $pos = $f[0][1] + strlen($f[0][0]);
                    } else {
                        $noeud['finContenu'] = $longueur;
                        $pos = $longueur;
                    }
                    $noeud['brut'] = true;
                    $parent['enfants'][] = $noeud;
                    unset($parent);
                    continue;
                }

                $parent['enfants'][] = $noeud;
                $pile[] = &$parent['enfants'][count($parent['enfants']) - 1];
                unset($parent);
                continue;
            }

            // « < » isolé : du texte.
            $ajouterTexte($lt, $lt + 1);
            $pos = $lt + 1;
        }

        // Éléments jamais fermés : jusqu'à la fin du document.
        for ($j = count($pile) - 1; $j >= 1; $j--) {
            $pile[$j]['finContenu'] = $longueur;
        }

        return $racine['enfants'];
    }

    private static function lireAttributs(string $brut): array
    {
        $attrs = [];
        if (preg_match_all('#([^\s"\'>/=]+)(?:\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s"\'=<>`]+)))?#', $brut, $m, PREG_SET_ORDER)) {
            foreach ($m as $a) {
                $nom = strtolower($a[1]);
                if (! array_key_exists($nom, $attrs)) {
                    $attrs[$nom] = html_entity_decode(($a[2] ?? '') . ($a[3] ?? '') . ($a[4] ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }
            }
        }

        return $attrs;
    }

    /** Parcours en profondeur des nœuds éléments (exclus compris). */
    private static function parcourir(array $noeuds, callable $rappel): void
    {
        foreach ($noeuds as $n) {
            if (! isset($n['nom'])) {
                continue;
            }
            $rappel($n);
            if ($n['enfants']) {
                self::parcourir($n['enfants'], $rappel);
            }
        }
    }

    private static function estExclu(array $n): bool
    {
        if (in_array($n['nom'], self::EXCLUS, true) || ! empty($n['brut'])) {
            return true;
        }
        if (strtolower((string) ($n['attrs']['translate'] ?? '')) === 'no') {
            return true;
        }
        if (preg_match('/(^|\s)notranslate(\s|$)/', (string) ($n['attrs']['class'] ?? ''))) {
            return true;
        }
        foreach ($n['attrs'] as $nom => $_) {
            if (preg_match(self::DYNAMIQUES, $nom)) {
                return true;
            }
        }

        return false;
    }

    /** Élément en ligne dont tout le contenu est lui-même en ligne. */
    private static function estEnLigne(array $n): bool
    {
        if (! in_array($n['nom'], self::EN_LIGNE, true) || self::estExclu($n)) {
            return false;
        }
        foreach ($n['enfants'] as $e) {
            if (isset($e['nom']) && ! self::estEnLigne($e)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Bloc de texte : contenu fait uniquement de texte et d'éléments en ligne,
     * ET du texte posé DIRECTEMENT dans l'élément (avec une lettre).
     *
     * Sans texte direct, ce sont les enfants qui sont repérés un par un :
     * `<li><a href="…">Menu</a></li>` étiquette le lien (l'adresse reste hors
     * de la traduction), un menu de dix liens donne dix textes et non un bloc,
     * et une image (souvent en base64) ne se retrouve pas dans une traduction
     * à côté d'un simple `<span>`. Avec texte direct, le bloc entier est
     * traduit d'un seul tenant (`<p>Buffets <strong>maison</strong></p>`).
     */
    private static function estBlocTexte(array $n): bool
    {
        if ($n['finContenu'] === null || in_array($n['nom'], ['html', 'body'], true)) {
            return false;
        }
        $direct = '';
        foreach ($n['enfants'] as $e) {
            if (isset($e['nom'])) {
                if (! self::estEnLigne($e)) {
                    return false;
                }
            } else {
                $direct .= $e['texte'];
            }
        }

        return (bool) preg_match('/\p{L}/u', html_entity_decode($direct, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    /** @return array<string, string> attribut → valeur (avec au moins une lettre) */
    private static function attributsTraduisibles(array $n): array
    {
        $valeurs = [];
        foreach (self::ATTRIBUTS as $nom) {
            $valeur = $n['attrs'][$nom] ?? null;
            if ($valeur === null || ! preg_match('/\p{L}/u', $valeur)) {
                continue;
            }
            // `value` : seulement le libellé d'un bouton.
            if ($nom === 'value' && ! ($n['nom'] === 'input'
                && in_array(strtolower((string) ($n['attrs']['type'] ?? '')), ['submit', 'button', 'reset'], true))) {
                continue;
            }
            $valeurs[$nom] = $valeur;
        }

        return $valeurs;
    }

    /** Réécrit la balise ouvrante avec les étiquettes voulues (null = retirée). */
    private static function editionOuvrante(string $html, array $n, ?string $cleT, ?string $cleA): array
    {
        $ouvrante = substr($html, $n['debut'], $n['finOuvrante'] - $n['debut']);
        $nouvelle = preg_replace('#\s+data-gx-ta?(?:\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s"\'=<>`]+))?(?=[\s/>])#i', '', $ouvrante);

        $ajout = ($cleT !== null ? ' data-gx-t="' . $cleT . '"' : '') . ($cleA !== null ? ' data-gx-ta="' . $cleA . '"' : '');
        if ($ajout !== '') {
            // Avant « /> » ou « > », espacement d'origine conservé.
            $nouvelle = preg_match('#(\s*)/>$#', $nouvelle, $fin)
                ? substr($nouvelle, 0, -strlen($fin[0])) . $ajout . $fin[0]
                : substr($nouvelle, 0, -1) . $ajout . '>';
        }

        return [$n['debut'], strlen($ouvrante), $nouvelle];
    }

    private static function remplacerAttribut(string $ouvrante, string $nom, string $valeur): string
    {
        $echappee = htmlspecialchars($valeur, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);

        return (string) preg_replace_callback(
            '#(\s' . preg_quote($nom, '#') . ')(\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s"\'=<>`]+))?(?=[\s/>])#i',
            static fn ($m) => $m[1] . '="' . $echappee . '"',
            $ouvrante,
            1
        );
    }

    /**
     * Applique des éditions [position, longueur, remplacement] de la fin vers
     * le début. Une édition contenue dans une autre déjà appliquée (attribut
     * d'une image dans un bloc traduit) est ignorée.
     */
    private static function appliquerEditions(string $html, array $editions): string
    {
        // Ordre du document ; la plus large d'abord à position égale.
        usort($editions, static fn ($a, $b) => $a[0] <=> $b[0] ?: $b[1] <=> $a[1]);
        $gardees = [];
        $finPrecedente = -1;
        foreach ($editions as $e) {
            if ($e[0] < $finPrecedente) {
                continue; // contenue dans la précédente
            }
            $gardees[] = $e;
            $finPrecedente = $e[0] + $e[1];
        }

        foreach (array_reverse($gardees) as [$debut, $longueur, $texte]) {
            $html = substr_replace($html, $texte, $debut, $longueur);
        }

        return $html;
    }

    private static function normaliser(string $texte): string
    {
        return trim((string) preg_replace('/\s+/u', ' ', $texte));
    }
}
