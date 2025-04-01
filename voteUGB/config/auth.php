<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'etudiants',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'etudiants',
        ],
        
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'etudiants' => [
            'driver' => 'eloquent',
            'model' => App\Models\Etudiant::class,
        ],
        
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'etudiants' => [
            'provider' => 'etudiants',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 30,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];