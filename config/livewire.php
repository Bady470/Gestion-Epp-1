<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Class Namespace
    |--------------------------------------------------------------------------
    |
    | This value sets the root class namespace for Livewire component classes
    | in your application.
    |
    */
    'class_namespace' => 'App\\Http\\Livewire',

    /*
    |--------------------------------------------------------------------------
    | Class Path
    |--------------------------------------------------------------------------
    |
    | This value sets the path where Livewire component class files are
    | created when running artisan make:livewire.
    |
    */
    'class_path' => app_path('Http/Livewire'),

    /*
    |--------------------------------------------------------------------------
    | View Path
    |--------------------------------------------------------------------------
    |
    | This value sets the path where Livewire component Blade templates are
    | stored when running file creation commands.
    |
    */
    'view_path' => resource_path('views/livewire'),
];
