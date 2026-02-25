<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\GrapesJSServiceProvider::class,
    Vendor\Editor\EditorServiceProvider::class,
    Vendor\Gemini\GeminiServiceProvider::class,
    Vendor\Customer\CustomerServiceProvider::class,
    Vendor\Website\WebsiteServiceProvider::class,
    Vendor\Destination\DestinationServiceProvider::class,
    Vendor\Administration\AdministrationServiceProvider::class,
    Vendor\GeoMap\GeoMapServiceProvider::class,
    Vendor\Activitie\ActivitieServiceProvider::class,
    Vendor\Etablissement\EtablissementServiceProvider::class,
    Vendor\Setting\SettingServiceProvider::class,
    Vendor\Users\UsersServiceProvider::class,
    Vendor\Theme\ThemeServiceProvider::class,
    Vendor\Template\TemplateServiceProvider::class,
    Vendor\Project\ProjectServiceProvider::class
];
