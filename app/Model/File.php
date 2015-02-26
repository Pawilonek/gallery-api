<?php

App::uses('AppModel', 'Model');

/**
 * File Model
 *
 * @property Image $Image
 */
class File extends AppModel {

    /**

      public $hasOne = array(
      'Image' => array(
      'className' => 'Image',
      'foreignKey' => 'file_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
      )
      );
     */
    public $hasMany = array(
        'Layout' => array(
            'className' => 'Layout',
            'foreignKey' => 'image_id',
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

    public function afterFind($result, $primary = false) {
        if (array_key_exists(0, $result)) {
            // wiele wpisów
            foreach ($result as $key => $file) {
                $result[$key]['File']['url'] = FULL_BASE_URL . DIRECTORY_SEPARATOR .
                        'galeria' . DIRECTORY_SEPARATOR . 'server' . DIRECTORY_SEPARATOR .
                        'uploadFiles' . DIRECTORY_SEPARATOR . $file['File']['filename'];
            }
        } else {
            // Tylko 1 wynik
            $result['url'] = FULL_BASE_URL . DIRECTORY_SEPARATOR .
                    'gallery-api' . DIRECTORY_SEPARATOR . 'uploadFiles' .
                    DIRECTORY_SEPARATOR . $result['filename'];
        }
        return $result;
    }

}
