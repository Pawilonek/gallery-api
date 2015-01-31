<?php

App::uses('AppModel', 'Model');

/**
 * Gallery Model
 *
 * @property Layout $Layout
 */
class Gallery extends AppModel {

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Layout' => array(
            'className' => 'Layout',
            'foreignKey' => 'gallery_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

}
