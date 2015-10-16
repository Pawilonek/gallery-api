<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    /**
     * Wybranie testowej bazy danych
     *
     * @var string
     */
    public $connection = 'test';

    /**
     * lista pól w bazie danych
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'username' => ['type' => 'string', 'length' => 50, 'null' => false],
        'password' => ['type' => 'string', 'length' => 100, 'null' => false],
        'email' => ['type' => 'string', 'length' => 50, 'null' => false],
        'role' => ['type' => 'string', 'length' => 10, 'null' => true],
        'created' => 'datetime',
        'modified' => 'datetime',
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];

    /**
     * testowe wpisy do bazy danych
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'username' => 'admin',
            'password' => '$2y$10$7nYaK0GciSTT1SDFFKDJ..DSmj61Kdp4Xxpl/Wi02dyAF6iCjMAyq', // admin
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'created' => '2015-10-16T12:00:15+0000',
            'modified' => '2015-10-16T12:00:15+0000'
        ],
        [
            'id' => 2,
            'username' => 'user',
            'password' => '$2y$10$7nYaK0GciSTT1SDFFKDJ..DSmj61Kdp4Xxpl/Wi02dyAF6iCjMAyq', // admin
            'email' => 'user@user.com',
            'role' => 'user',
            'created' => '2015-10-16T12:00:15+0000',
            'modified' => '2015-10-16T12:00:15+0000'
        ]
    ];
}
