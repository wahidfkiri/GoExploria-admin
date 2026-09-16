<?php

namespace Vendor\Activities\Support;

/**
 * Règles d'édition du canvas publiées par erreur dans les contenus d'activité.
 *
 * Jusqu'au 2026-09-16, le canvas VvvebJS des contenus d'activité portait ses
 * règles d'édition dans un <style> de son <head>. Or la sauvegarde de
 * l'éditeur récolte TOUTES les balises <style> du <head> et les enregistre en
 * tête du contenu : ces règles partaient donc sur le site public — Inter sur
 * tout le corps, `img, video { height: auto }` (qui défait le recouvrement
 * des vidéos du héros) et `iframe, video { pointer-events: none }` (vidéos
 * impossibles à lancer). Rechargées dans le corps à l'ouverture suivante,
 * elles revenaient une fois de plus à chaque sauvegarde.
 *
 * L'admin sert désormais ces règles par <link>, jamais récolté, et nettoie
 * les contenus (au rendu du canvas, et par la commande
 * `activites:page-par-defaut --heros`). Ici, on les retire AU RENDU du site,
 * pour qu'aucune page pas encore nettoyée ne les affiche.
 *
 * Même logique que Vendor\Activitie\Support\ReglesEdition côté admin — les
 * deux projets sont déployés séparément.
 */
class ReglesEdition
{
    /** Première règle du bloc — une seule version du canvas a existé. */
    private const DEBUT = 'html, body { margin: 0; padding: 0; min-height: 100%; }';

    /**
     * Le bloc, de sa première règle à sa dernière (`.gx-vide { … }`), sans
     * jamais franchir la fin de la balise <style> qui le contient.
     */
    private const BLOC = '/html, body \{ margin: 0; padding: 0; min-height: 100%; \}(?:(?!<\/style>).)*?\.gx-vide \{[^}]*\}/s';

    public static function present(?string $html): bool
    {
        return str_contains((string) $html, self::DEBUT);
    }

    public static function retirer(?string $html): string
    {
        $html = (string) $html;

        if (! self::present($html)) {
            return $html;
        }

        $html = preg_replace(self::BLOC, '', $html) ?? $html;

        // Balises <style> vidées par le retrait : elles n'ont plus d'objet.
        return preg_replace('/<style\b[^>]*>\s*<\/style>\s*/i', '', $html) ?? $html;
    }
}
