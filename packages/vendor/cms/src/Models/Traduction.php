<?php

namespace Vendor\Cms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Traduction d'un texte d'un site d'établissement (sites multilingues).
 * ⚠ Modèle présent en DOUBLE (admin + front). Cf. la migration
 * 2026_11_10_000001_create_cms_traductions_table.
 */
class Traduction extends Model
{
    public const STATUT_AUTO = 'auto';         // proposée (IA), à relire
    public const STATUT_RELUE = 'relue';
    public const STATUT_A_REVOIR = 'a_revoir'; // le texte principal a changé

    public const PAGE = 'page';
    public const REGION = 'region';

    protected $connection = 'cms';
    protected $table = 'cms_traductions';

    protected $fillable = [
        'etablissement_id',
        'proprietaire_type',
        'proprietaire_id',
        'langue',
        'cle',
        'texte',
        'empreinte_source',
        'statut',
        'modifie_par',
    ];

    /** Préfixe des étiquettes d'un propriétaire : p12 (page), r5 (région). */
    public static function prefixe(string $type, int $id): string
    {
        return ($type === self::REGION ? 'r' : 'p') . $id;
    }

    /** Table présente ? (base pas encore migrée : rien n'est traduit) */
    public static function disponible(): bool
    {
        static $dispo = null;

        if ($dispo === null) {
            try {
                $dispo = \Illuminate\Support\Facades\Schema::connection('cms')->hasTable('cms_traductions');
            } catch (\Throwable $e) {
                $dispo = false;
            }
        }

        return $dispo;
    }
}
