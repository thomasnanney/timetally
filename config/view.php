<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        base_path('app/API/resources/views'),
        base_path('app/Auth/resources/views'),
        base_path('app/Clients/resources/views'),
        base_path('app/Core/resources/views'),
        base_path('app/Core/resources/views/layouts'),
        base_path('app/Dashboard/resources/views'),
        base_path('app/Dashboard/resources/views/layouts'),
        base_path('app/Organizations/resources/views'),
        base_path('app/Projects/resources/views'),
        base_path('app/Reports/resources/views'),
        base_path('app/Timer/resources/views'),
        base_path('app/Users/resources/views'),
        base_path('app/Workspaces/resources/views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => realpath(storage_path('framework/views')),

];
