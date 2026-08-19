<?php

namespace Vendor\Cms\Models;

/*
 * ATTENTION — copie LECTURE SEULE du modèle de l'espace entreprise.
 *
 * Le site affiche le calendrier ; il ne crée ni ne supprime de période. La
 * gestion se fait dans l'onglet « Immobilier » du tableau de bord, dépôt
 * admin.goexploriabusiness.com, même chemin.
 *
 * Règle à ne pas perdre de vue des deux côtés : une période occupe les NUITS
 * de l'arrivée au départ EXCLU. Deux séjours qui se touchent (l'un finit le 7,
 * l'autre commence le 7) ne se chevauchent PAS.
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyBooking extends Model
{
    use SoftDeletes;

    protected $connection = 'cms';
    protected $table = 'cms_property_bookings';

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function scopePourBien($query, $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    public function scopeAVenir($query, $depuis = null)
    {
        return $query->whereDate('end_date', '>', $depuis ?: now()->toDateString());
    }

    /** Périodes qui chevauchent [$debut, $fin[ — cf. la règle ci-dessus. */
    public function scopeChevauchant($query, string $debut, string $fin)
    {
        return $query->whereDate('start_date', '<', $fin)
            ->whereDate('end_date', '>', $debut);
    }
}
