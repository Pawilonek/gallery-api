<?php

App::uses('AppModel', 'Model');

/**
 * Authentication Model
 *
 * @property User $User
 */
class Authentication extends AppModel {

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
