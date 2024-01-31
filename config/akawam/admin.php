<?php

$actions = ['view' => false, 'create' => false, 'edit' => false, 'delete' => false];

return [
    'path' => env('ADMIN_PATH', 'admin'), // Access path of Admin Interface
    'superAdmin' => 'SuperAdmin', // Default SuperAdmin name
    'permissions' => [
        'Paramètres' => [
            'Administrateurs' => $actions,
            'Attributs' => $actions,
            'Langues' => $actions,
            'Site Internet' => $actions,
        ],
    ]
];
