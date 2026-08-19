<?php

namespace Vendor\Cms\Models;

/*
 * ATTENTION — copie ÉCRITURE SEULE du modèle de l'espace entreprise.
 *
 * Le site public et le back-office sont deux dépôts distincts qui partagent
 * la base « cms ». Ici, le sens est l'inverse de [[Property]] : le SITE écrit
 * les demandes reçues dans la fiche d'un bien, et l'espace entreprise les
 * lit et les suit. Ce fichier ne garde donc que ce qu'il faut pour créer une
 * demande — aucune méthode de présentation pour l'administration.
 *
 * Le modèle d'origine vit dans admin.goexploriabusiness.com, même chemin.
 * Toute colonne ajoutée ici doit l'être des deux côtés.
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyRequest extends Model
{
    use SoftDeletes;

    protected $connection = 'cms';
    protected $table = 'cms_property_requests';

    public const STATUT_NOUVEAU = 'nouveau';

    protected $fillable = [
        'etablissement_id', 'property_id', 'agent_id',
        'property_title', 'property_reference',
        'name', 'email', 'phone',
        'arrival_date', 'departure_date', 'adults', 'children',
        'message', 'status', 'ip', 'user_agent',
    ];

    protected $casts = [
        'arrival_date'   => 'date',
        'departure_date' => 'date',
        'adults'         => 'integer',
        'children'       => 'integer',
    ];
}
