<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity.
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $role
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Authentication[] $authentications
 */
class User extends Entity
{

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    // kolumny które powinny zostać ukryte podczas
    // przekazywania obiektu do kontrolera
    protected $_hidden = [
        'password'
    ];

    /**
     * Funkcja która odpowiada za hashowanie hasła
     * zapisywanego do bazy danych
     *
     * @param string $password
     * @return string
     */
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
}
