<?php

$config = [
    'SimpleRbac' => [
        'roles' => [
            'admin',
            'user',
        ],
        'actionMap' => [
            'Articles' => [
                'view' => ['user', 'admin'],
                'add' => ['admin'],
                'edit' => ['admin'],
                'delete' => ['admin'],
            ],
            'Users' => [
                '*' => ['admin'],
            ],
        ]
    ]
];