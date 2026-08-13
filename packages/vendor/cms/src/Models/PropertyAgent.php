<?php

namespace Vendor\Cms\Models;

/*
 * ATTENTION — copie LECTURE SEULE du modèle de l'espace entreprise.
 *
 * Le site public et le back-office sont deux dépôts distincts qui partagent
 * la base « cms ». Ce fichier reprend le modèle d'origine
 * (admin.goexploriabusiness.com, même chemin) en n'en gardant que ce dont
 * l'affichage a besoin : relations, portées de lecture et mise en forme.
 * Aucune écriture ne part d'ici — la saisie se fait dans l'onglet
 * « Immobilier » du tableau de bord.
 *
 * Toute évolution du contrat exposé au template (toApiArray) doit être
 * reportée des deux côtés, faute de quoi le site affichera des champs que le
 * script ne sait plus lire.
 */
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Négociateur rattaché aux biens d'un établissement.
 *
 * Séparé des biens parce qu'un même négociateur en suit plusieurs : dupliquer
 * son nom, sa photo et ses coordonnées sur chaque annonce obligerait à les
 * corriger une par une.
 */
class PropertyAgent extends Model
{
    use SoftDeletes;

    protected $connection = 'cms';
    protected $table = 'cms_property_agents';

    protected $casts = [
        'is_active' => 'boolean',
        'rating'    => 'decimal:1',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class, 'agent_id');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_active', true);
    }

    /** Forme attendue par le script du template — identique au data.js d'origine. */
    public function toApiArray(): array
    {
        return [
            'id'        => 'a' . $this->id,
            'name'      => (string) $this->name,
            'specialty' => (string) $this->specialty,
            'city'      => (string) $this->city,
            'listings'  => (int) ($this->properties_count ?? 0),
            'rating'    => $this->rating !== null ? (float) $this->rating : null,
            'phone'     => (string) $this->phone,
            'email'     => (string) $this->email,
            // Le lien WhatsApp n'accepte que des chiffres.
            'whatsapp'  => preg_replace('/\D+/', '', (string) ($this->whatsapp ?: $this->phone)),
            'photo'     => $this->photo ?: null,
        ];
    }
}
