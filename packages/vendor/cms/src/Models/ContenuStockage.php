<?php

namespace Vendor\Cms\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Mode de stockage des contenus choisi pour un propriétaire (établissement,
 * activité, catégorie, destination) — absent = « base ».
 */
class ContenuStockage extends Model
{
    public const BASE = 'base';
    public const FICHIERS = 'fichiers';

    protected $connection = 'cms';
    protected $table = 'contenu_stockages';

    protected $fillable = ['proprietaire_type', 'proprietaire_id', 'etablissement_id', 'mode', 'bascule_le', 'base_liberee_le', 'modifie_par'];

    protected $casts = [
        'bascule_le' => 'datetime',
        'base_liberee_le' => 'datetime',
    ];
}
