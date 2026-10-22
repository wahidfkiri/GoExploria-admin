<?php

namespace Vendor\Cms\Contenus;

use InvalidArgumentException;

/**
 * Les propriétaires de contenus et leur clé courte, pour la commande et les
 * cartes « Stockage des contenus » :
 *
 *   9626 | etablissement:9626   → App\Models\Etablissement #9626
 *   activite:12                 → App\Models\Activity #12
 *   categorie:3                 → App\Models\Category #3
 *   villes:12, regions:4, …     → la destination du niveau (clés de DestinationNiveaux)
 *
 * Un propriétaire est le COUPLE (classe, identifiant) : les identifiants se
 * répètent d'une table à l'autre (ville #12 ≠ région #12).
 */
final class Proprietaires
{
    public const ETABLISSEMENT = 'App\\Models\\Etablissement';
    public const ACTIVITE = 'App\\Models\\Activity';
    public const CATEGORIE = 'App\\Models\\Category';

    /** @return array<string, string> clé courte => classe */
    public static function types(): array
    {
        $types = [
            'etablissement' => self::ETABLISSEMENT,
            'activite' => self::ACTIVITE,
            'categorie' => self::CATEGORIE,
        ];

        // Les 8 niveaux de destination (projet admin seulement).
        if (class_exists(\Vendor\Destination\Support\DestinationNiveaux::class)) {
            foreach (\Vendor\Destination\Support\DestinationNiveaux::NIVEAUX as $cle => $niveau) {
                $types[$cle] = $niveau['modele'];
            }
        }

        return $types;
    }

    /**
     * « activite:12 » → [App\Models\Activity, 12] ; un nombre seul désigne un
     * établissement (compatibilité avec le premier pilote).
     *
     * @return array{0: string, 1: int}
     */
    public static function resoudre(string $reference): array
    {
        $reference = trim($reference);

        if (ctype_digit($reference)) {
            return [self::ETABLISSEMENT, (int) $reference];
        }

        [$cle, $id] = array_pad(explode(':', $reference, 2), 2, '');
        $types = self::types();

        if (! isset($types[$cle]) || ! ctype_digit($id)) {
            throw new InvalidArgumentException(
                "Propriétaire inconnu « {$reference} ». Formes acceptées : 9626, "
                . implode(', ', array_map(fn ($c) => "{$c}:ID", array_keys($types))) . '.'
            );
        }

        return [$types[$cle], (int) $id];
    }

    public static function reference(string $classe, int $id): string
    {
        $cle = array_search($classe, self::types(), true);

        return ($cle === false ? $classe : $cle) . ':' . $id;
    }
}
