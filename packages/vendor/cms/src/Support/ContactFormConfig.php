<?php

namespace Vendor\Cms\Support;

/**
 * Configuration du formulaire de contact, par établissement.
 * Stockée dans cms_settings (group « contact », clé « contact_form_config »).
 * Utilisée par l'admin (édition) et par le front (rendu + validation).
 */
class ContactFormConfig
{
    public const SETTING_KEY   = 'contact_form_config';
    public const SETTING_GROUP = 'contact';

    /**
     * Champs disponibles, dans l'ordre d'affichage.
     * type: text | email | tel | textarea | checkbox
     */
    public static function fields(): array
    {
        return [
            'first_name' => ['type' => 'text',     'label' => 'Prénom',     'enabled' => true,  'required' => true,  'placeholder' => '', 'default' => '', 'half' => true],
            'last_name'  => ['type' => 'text',     'label' => 'Nom',        'enabled' => true,  'required' => false, 'placeholder' => '', 'default' => '', 'half' => true],
            'email'      => ['type' => 'email',    'label' => 'Courriel',   'enabled' => true,  'required' => true,  'placeholder' => '', 'default' => '', 'half' => true],
            'phone'      => ['type' => 'tel',      'label' => 'Téléphone',  'enabled' => true,  'required' => false, 'placeholder' => '', 'default' => '', 'half' => true],
            'company'    => ['type' => 'text',     'label' => 'Entreprise', 'enabled' => false, 'required' => false, 'placeholder' => '', 'default' => '', 'half' => true],
            'subject'    => ['type' => 'text',     'label' => 'Sujet',      'enabled' => true,  'required' => false, 'placeholder' => '', 'default' => '', 'half' => false],
            'message'    => ['type' => 'textarea', 'label' => 'Votre message', 'enabled' => true, 'required' => true, 'placeholder' => '', 'default' => '', 'half' => false],
            'consent'    => ['type' => 'checkbox', 'label' => "J'accepte d'être recontacté au sujet de ma demande.", 'enabled' => true, 'required' => false, 'placeholder' => '', 'default' => '', 'half' => false],
            'newsletter_opt_in' => ['type' => 'checkbox', 'label' => 'Je souhaite recevoir les actualités et offres.', 'enabled' => false, 'required' => false, 'placeholder' => '', 'default' => '', 'half' => false],
        ];
    }

    /**
     * Configuration par défaut complète.
     */
    public static function defaults(): array
    {
        return [
            'title'           => 'Contactez-nous',
            'subtitle'        => 'Envoyez-nous un message, nous vous répondrons rapidement.',
            'submit_label'    => 'Envoyer le message',
            'success_message' => 'Merci, votre message a bien été envoyé.',
            'fields'          => self::fields(),
        ];
    }

    /**
     * Configuration effective pour un établissement (défauts + surcharge BD).
     * $etablissement doit exposer getSetting() (trait HasSettings).
     */
    public static function for($etablissement): array
    {
        $defaults = self::defaults();

        $raw = null;
        try {
            $raw = $etablissement?->getSetting(self::SETTING_KEY, null, self::SETTING_GROUP);
        } catch (\Throwable $e) {
            $raw = null;
        }

        if (is_string($raw)) {
            $raw = json_decode($raw, true);
        }
        if (! is_array($raw)) {
            return $defaults;
        }

        // Fusion superficielle des textes
        $config = array_merge($defaults, array_intersect_key($raw, array_flip(['title', 'subtitle', 'submit_label', 'success_message'])));

        // Fusion champ par champ (on ne garde que les champs connus)
        $config['fields'] = [];
        foreach ($defaults['fields'] as $key => $def) {
            $override = is_array($raw['fields'][$key] ?? null) ? $raw['fields'][$key] : [];
            $config['fields'][$key] = array_merge($def, array_intersect_key($override, array_flip(['label', 'enabled', 'required', 'placeholder', 'default'])));
            // Normalisation des booléens
            $config['fields'][$key]['enabled']  = (bool) ($config['fields'][$key]['enabled'] ?? false);
            $config['fields'][$key]['required'] = (bool) ($config['fields'][$key]['required'] ?? false);
        }

        return $config;
    }

    /**
     * Liste des champs activés (clé => config), dans l'ordre.
     */
    public static function enabledFields(array $config): array
    {
        return array_filter($config['fields'] ?? [], fn ($f) => ! empty($f['enabled']));
    }

    /**
     * Nettoie/normalise une configuration entrante (depuis l'admin) : on ne
     * garde que les clés et champs connus, on borne les longueurs et on caste.
     */
    public static function sanitize($input): array
    {
        $defaults = self::defaults();
        $input = is_array($input) ? $input : [];

        $cut = fn ($v, $len, $fallback = '') => mb_substr(trim((string) ($v ?? '')), 0, $len) ?: $fallback;

        $out = [
            'title'           => $cut($input['title'] ?? null, 191, $defaults['title']),
            'subtitle'        => $cut($input['subtitle'] ?? null, 255, ''),
            'submit_label'    => $cut($input['submit_label'] ?? null, 100, $defaults['submit_label']),
            'success_message' => $cut($input['success_message'] ?? null, 255, $defaults['success_message']),
            'fields'          => [],
        ];

        $inFields = is_array($input['fields'] ?? null) ? $input['fields'] : [];
        foreach ($defaults['fields'] as $key => $def) {
            $f = is_array($inFields[$key] ?? null) ? $inFields[$key] : [];
            $isCheckbox = $def['type'] === 'checkbox';
            $out['fields'][$key] = [
                'type'        => $def['type'],
                'enabled'     => (bool) ($f['enabled'] ?? $def['enabled']),
                'required'    => $isCheckbox ? false : (bool) ($f['required'] ?? $def['required']),
                'label'       => $cut($f['label'] ?? null, 191, $def['label']),
                'placeholder' => $isCheckbox ? '' : $cut($f['placeholder'] ?? null, 191, ''),
                'default'     => $isCheckbox ? '' : $cut($f['default'] ?? null, 191, ''),
                'half'        => $def['half'],
            ];
        }

        return $out;
    }
}
