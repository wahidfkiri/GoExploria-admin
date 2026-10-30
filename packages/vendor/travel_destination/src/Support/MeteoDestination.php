<?php

namespace Vendor\TravelDestination\Support;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Météo d'une page de destination — LECTURE SEULE.
 *
 * L'admin interroge Open-Meteo (commande horaire `destinations:meteo` et
 * onglet « Météo » de l'espace destination) et range le résultat, déjà mis en
 * forme, dans `destination_meteo` (base partagée). Le site ne fait que lire :
 * aucune requête externe pendant l'affichage d'une page.
 *
 * Rien à afficher (null) si : table absente (migration pas encore passée),
 * météo désactivée, jamais récupérée, ou plus vieille que 6 heures — mieux
 * vaut pas de météo qu'une météo périmée.
 */
final class MeteoDestination
{
    public const PEREMPTION_HEURES = 6;
    public const POSITIONS = ['banniere', 'apres_carte', 'fin'];

    /**
     * @param  string  $niveau  type normalisé du site (country, city, …)
     * @return array{position:string, jours:int, unite:string, donnees:array, rafraichi_le:Carbon}|null
     */
    public static function pour(string $niveau, int $destinationId): ?array
    {
        static $tablePresente = null;

        try {
            $tablePresente ??= Schema::hasTable('destination_meteo');
            if (! $tablePresente) {
                return null;
            }

            $ligne = DB::table('destination_meteo')
                ->where('niveau', $niveau)
                ->where('destination_id', $destinationId)
                ->where('actif', true)
                ->first(['jours', 'unite', 'position', 'donnees', 'rafraichi_le']);
        } catch (\Throwable $e) {
            return null;   // une panne de lecture ne doit jamais casser la page
        }

        if (! $ligne || ! $ligne->rafraichi_le || ! $ligne->donnees) {
            return null;
        }

        $rafraichi = Carbon::parse($ligne->rafraichi_le);
        if ($rafraichi->lt(now()->subHours(self::PEREMPTION_HEURES))) {
            return null;
        }

        $donnees = json_decode((string) $ligne->donnees, true);
        if (! is_array($donnees) || empty($donnees['actuel']) || empty($donnees['jours'])) {
            return null;
        }

        return [
            'position'     => in_array($ligne->position, self::POSITIONS, true) ? $ligne->position : 'banniere',
            'jours'        => max(1, min(7, (int) $ligne->jours ?: 5)),
            'unite'        => $ligne->unite === 'fahrenheit' ? 'fahrenheit' : 'celsius',
            'donnees'      => $donnees,
            'rafraichi_le' => $rafraichi,
        ];
    }

    /** Température affichée (arrondie) dans l'unité de la destination. */
    public static function temperature($celsius, string $unite): string
    {
        if (! is_numeric($celsius)) {
            return '—';
        }

        $valeur = $unite === 'fahrenheit' ? $celsius * 9 / 5 + 32 : $celsius;

        return (int) round($valeur) . '°';
    }
}
