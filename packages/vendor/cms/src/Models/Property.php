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
 * Bien immobilier d'un établissement, stocké dans la base « cms ».
 *
 * Alimente le template « NadiImmo » : sa recherche, ses cartes et sa page de
 * détail lisent ces enregistrements au lieu des données de démonstration
 * livrées avec le template.
 *
 * La forme exposée au site (toApiArray) reprend exactement le contrat que le
 * script du template attendait de son fichier data.js d'origine — champs et
 * types identiques. Le template n'a donc pas à savoir d'où viennent les biens,
 * et il continue de fonctionner avec ses données de démonstration lorsque
 * l'établissement n'en a pas encore saisi.
 */
class Property extends Model
{
    use SoftDeletes;

    protected $connection = 'cms';
    protected $table = 'cms_properties';

    public const INTENT_VENTE    = 'vente';
    public const INTENT_LOCATION = 'location';

    public const INTENTS = [
        self::INTENT_VENTE    => 'À vendre',
        self::INTENT_LOCATION => 'À louer',
    ];

    /** Types proposés par défaut ; l'établissement peut en saisir d'autres. */
    public const TYPES = [
        'Appartement', 'Villa', 'Maison', 'Terrain',
        'Studio', 'Bureau', 'Local commercial', 'Immeuble', 'Ferme',
    ];

    public const STANDINGS = [
        'Standard', 'Haut standing', 'Prestige', 'Neuf',
        'Investissement', 'Professionnel', 'Commercial',
    ];

    protected $casts = [
        'gallery'     => 'array',
        'amenities'   => 'array',
        'is_new'      => 'boolean',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'price'       => 'decimal:2',
        'latitude'    => 'decimal:7',
        'longitude'   => 'decimal:7',
    ];

    public function agent()
    {
        return $this->belongsTo(PropertyAgent::class, 'agent_id');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForEtablissement($query, $etablissementId)
    {
        return $query->where('etablissement_id', $etablissementId);
    }

    /**
     * Applique les filtres de la barre de recherche du template.
     *
     * Les critères vides sont ignorés : le formulaire envoie systématiquement
     * tous ses champs, la plupart à « all » ou à vide.
     *
     * @param  array<string,mixed>  $criteres
     */
    public function scopeRecherche($query, array $criteres)
    {
        $texte = trim((string) ($criteres['q'] ?? ''));
        if ($texte !== '') {
            // Recherche libre sur les seuls champs que l'utilisateur voit.
            $query->where(function ($q) use ($texte) {
                foreach (['title', 'area', 'city', 'reference', 'description'] as $colonne) {
                    $q->orWhere($colonne, 'like', '%' . $texte . '%');
                }
            });
        }

        foreach (['intent' => 'intent', 'type' => 'type', 'city' => 'city', 'standing' => 'standing'] as $cle => $colonne) {
            $valeur = $criteres[$cle] ?? null;
            if ($valeur !== null && $valeur !== '' && $valeur !== 'all') {
                $query->where($colonne, $valeur);
            }
        }

        foreach ([
            ['price_min',   'price',    '>='],
            ['price_max',   'price',    '<='],
            ['surface_min', 'surface',  '>='],
            ['bedrooms',    'bedrooms', '>='],
            ['bathrooms',   'bathrooms', '>='],
        ] as [$cle, $colonne, $operateur]) {
            $valeur = $criteres[$cle] ?? null;
            if ($valeur !== null && $valeur !== '' && is_numeric($valeur)) {
                $query->where($colonne, $operateur, $valeur);
            }
        }

        return $query;
    }

    /**
     * Forme attendue par le script du template — identique au data.js d'origine.
     *
     * @return array<string,mixed>
     */
    public function toApiArray(): array
    {
        $agent = $this->relationLoaded('agent') ? $this->agent : null;

        return [
            'id'          => 'p' . $this->id,
            'title'       => (string) $this->title,
            'type'        => (string) $this->type,
            'intent'      => (string) $this->intent,
            'price'       => (float) $this->price,
            'currency'    => (string) ($this->currency ?: 'TND'),
            'priceLabel'  => $this->price_label ?: null,
            'city'        => (string) $this->city,
            'area'        => (string) $this->area,
            'surface'     => $this->surface !== null ? (int) $this->surface : null,
            'bedrooms'    => $this->bedrooms !== null ? (int) $this->bedrooms : null,
            'bathrooms'   => $this->bathrooms !== null ? (int) $this->bathrooms : null,
            'parking'     => $this->parking !== null ? (int) $this->parking : null,
            'standing'    => $this->standing ?: null,
            'isNew'       => (bool) $this->is_new,
            'match'       => (int) $this->match_score,
            'agent'       => $agent ? 'a' . $agent->id : null,
            'cover'       => $this->cover ?: ($this->gallery[0] ?? null),
            'gallery'     => array_values(array_filter((array) $this->gallery)),
            'description' => (string) $this->description,
            'amenities'   => array_values(array_filter((array) $this->amenities)),
            'reference'   => $this->reference ?: null,
            'lat'         => $this->latitude !== null ? (float) $this->latitude : null,
            'lng'         => $this->longitude !== null ? (float) $this->longitude : null,
        ];
    }
}
