<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\GrapesJSServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    Vendor\Theme\ThemeServiceProvider::class,
    Vendor\Destination\DestinationServiceProvider::class,
    Vendor\GeoMap\GeoMapServiceProvider::class,
    Vendor\Cms\CmsServiceProvider::class,
    Vendor\Cms\Providers\CmsViewServiceProvider::class,
    Vendor\MailMarketing\MailMarketingServiceProvider::class,
];
