<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Authentications
 */
class UsersTable extends Table
{
    // role użytkowników wykorzystywanych w systemie
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    /**
     *
     * @param array $config
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Metoda odpowiedzialna za przygotowanie reguł walidacji
     *
     * @param Validator $validator
     * @return Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->add('role', 'inList', [
                'rule' => ['inList', [self::ROLE_ADMIN, self::ROLE_USER]],
                'message' => 'Please enter a valid role'
            ])
            ->allowEmpty('role');

        return $validator;
    }

    /**
     * Dodatkowe reguły walidacji
     *
     * @param RulesChecker $rules
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        // nazwa użytkownika powinna być unikalna
        $rules->add($rules->isUnique(['username']));
        // adres email powinien być unikalny
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }
}
