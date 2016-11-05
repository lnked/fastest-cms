<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    */
    'NAME' => 'Fastest CMS',

    /*
    |--------------------------------------------------------------------------
    | Cache directory
    |--------------------------------------------------------------------------
    |
    */
    'DEV_MODE' => false,
    
    /*
    |--------------------------------------------------------------------------
    | Frontend templating
    |--------------------------------------------------------------------------
    |
    */
    'TEMPLATING_FRONTEND' => 'smarty',
    
    /*
    |--------------------------------------------------------------------------
    | Backend templating
    |--------------------------------------------------------------------------
    |
    */
    'TEMPLATING_BACKEND' => 'smarty',
    
    /*
    |--------------------------------------------------------------------------
    | Cache directory
    |--------------------------------------------------------------------------
    |
    */
    'TEMPLATING_DEBUG' => false,
    
    /*
    |--------------------------------------------------------------------------
    | Cache directory
    |--------------------------------------------------------------------------
    |
    */
    'PATH_TEMPLATES' => FASTEST_ROOT.APPS_ROOT.DS.'app'.DS.'views',
    
    /*
    |--------------------------------------------------------------------------
    | Cache directory
    |--------------------------------------------------------------------------
    |
    */
    'PATH_DRIVERS' => FASTEST_ROOT.APPS_ROOT.DS.'app'.DS.'drivers',
    
    /*
    |--------------------------------------------------------------------------
    | Cache directory
    |--------------------------------------------------------------------------
    |
    */
    'PATH_RUNTIME' => FASTEST_ROOT.APPS_ROOT.DS.'runtime',
    
    /*
    |--------------------------------------------------------------------------
    | CSRF Protection
    |--------------------------------------------------------------------------
    |
    */
    'CSRF_PROTECTION' => true,
    
    /*
    |--------------------------------------------------------------------------
    | Public root
    |--------------------------------------------------------------------------
    |
    */
    'ADMIN_DIR' => 'cp',
    
    /*
    |--------------------------------------------------------------------------
    | Public root
    |--------------------------------------------------------------------------
    |
    */
    'PUBLIC_ROOT' => 'public_html',
    
    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */
    'CACHING' => false,

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */
    'DEBUG' => true,

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */
    'LOCALE' => 'ru'
];