<?php

namespace Vendor\Cms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Une version d'un champ de contenu, rangée dans le dépôt de fichiers.
 * `manifeste` = liste de segments {t: html|css, h: empreinte, o?, f?}.
 */
class ContenuRevision extends Model
{
    public const UPDATED_AT = null;

    protected $connection = 'cms';
    protected $table = 'contenu_revisions';

    protected $fillable = [
        'proprietaire_type', 'proprietaire_id', 'etablissement_id', 'ressource_type', 'ressource_id', 'champ',
        'manifeste', 'empreinte', 'taille', 'origine', 'auteur_id',
    ];

    protected $casts = [
        'manifeste' => 'array',
    ];
}
