<?php

namespace Vendor\Cms\Contenus;

/**
 * Découpe un contenu « <style>…</style>html… » en segments, et le recompose
 * à l'octet près.
 *
 * Chaque bloc <style> devient un segment CSS à part : la feuille d'un
 * template, recopiée à l'identique dans l'accueil, les pages secondaires,
 * l'en-tête et le pied, ne produit alors qu'UN seul objet dans le dépôt
 * (même empreinte). Le HTML entre les blocs est gardé tel quel.
 *
 * La recomposition doit rendre exactement la valeur d'origine : les balises
 * d'ouverture et de fermeture (attributs, casse) sont donc conservées dans le
 * manifeste, pas reconstruites.
 *
 * ⚠ Aucune expression régulière : une feuille de plus d'un mégaoctet fait
 * échouer `.*?` (limite de retour arrière de PCRE), cf. SeparateurStyles.
 */
final class Decoupeur
{
    /**
     * @return list<array{t: 'html'|'css', contenu: string, o?: string, f?: string}>
     */
    public static function decouper(string $valeur): array
    {
        $segments = [];
        $pos = 0;
        $longueur = strlen($valeur);

        while ($pos < $longueur && ($debut = stripos($valeur, '<style', $pos)) !== false) {
            // « <styles> » ou « <style-x> » ne sont pas des blocs de style.
            $suivant = $valeur[$debut + 6] ?? '';
            if ($suivant !== '>' && ! ctype_space($suivant)) {
                $segments[] = ['t' => 'html', 'contenu' => substr($valeur, $pos, $debut + 6 - $pos)];
                $pos = $debut + 6;

                continue;
            }

            $finOuvrante = strpos($valeur, '>', $debut);
            $fermante = $finOuvrante === false ? false : stripos($valeur, '</style', $finOuvrante);
            $finFermante = $fermante === false ? false : strpos($valeur, '>', $fermante);

            if ($finFermante === false) {
                break; // bloc non fermé : le reste est rendu tel quel
            }

            if ($debut > $pos) {
                $segments[] = ['t' => 'html', 'contenu' => substr($valeur, $pos, $debut - $pos)];
            }

            $segments[] = [
                't' => 'css',
                'contenu' => substr($valeur, $finOuvrante + 1, $fermante - $finOuvrante - 1),
                'o' => substr($valeur, $debut, $finOuvrante + 1 - $debut),
                'f' => substr($valeur, $fermante, $finFermante + 1 - $fermante),
            ];

            $pos = $finFermante + 1;
        }

        if ($pos < $longueur) {
            $segments[] = ['t' => 'html', 'contenu' => substr($valeur, $pos)];
        }

        return self::fusionnerHtml($segments);
    }

    /**
     * @param  list<array{t: string, contenu: string, o?: string, f?: string}>  $segments
     */
    public static function recomposer(array $segments): string
    {
        $sortie = '';

        foreach ($segments as $segment) {
            $sortie .= $segment['t'] === 'css'
                ? ($segment['o'] ?? '<style>') . $segment['contenu'] . ($segment['f'] ?? '</style>')
                : $segment['contenu'];
        }

        return $sortie;
    }

    /** Recolle les morceaux HTML consécutifs (faux départs « <styles »). */
    private static function fusionnerHtml(array $segments): array
    {
        $fusion = [];

        foreach ($segments as $segment) {
            $dernier = array_key_last($fusion);

            if ($segment['t'] === 'html' && $dernier !== null && $fusion[$dernier]['t'] === 'html') {
                $fusion[$dernier]['contenu'] .= $segment['contenu'];
            } else {
                $fusion[] = $segment;
            }
        }

        return $fusion;
    }
}
