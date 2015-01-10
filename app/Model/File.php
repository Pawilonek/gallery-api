<?php
App::uses('AppModel', 'Model');
/**
 * File Model
 *
 * @property Image $Image
 */
class File extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'Image' => array(
			'className' => 'Image',
			'foreignKey' => 'file_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
