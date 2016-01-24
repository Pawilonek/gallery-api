<?php

$config = [
    'SimpleRbac' => [
        'roles' => [
            'admin',
            'user',
        ],
        'actionMap' => [
            'Galleries' => [
                //'index' => [],
                //'view' => [],
                'add' => ['admin'],
                'edit' => ['admin'],
                'delete' => ['admin'],
            ],
            'Images' => [
                'index' => ['admin'],
                'view' => ['admin'],
                'add' => ['admin'],
                'edit' => ['admin'],
                'delete' => ['admin'],
            ],
            'Layouts' => [
                'index' => ['admin'],
                'view' => ['admin'],
                'add' => ['admin'],
                'edit' => ['admin'],
                'delete' => ['admin'],
            ],
            'Pages' => [
                //'index' => [],
                //'view' => [],
                'add' => ['admin'],
                'edit' => ['admin'],
                'delete' => ['admin'],
            ],
            'Users' => [
                'index' => ['admin'],
                'view' => ['admin'],
                'add' => ['admin'],
                'edit' => ['admin'],
                'delete' => ['admin'],
                //'login' => []
            ],
        ]
    ]
];
