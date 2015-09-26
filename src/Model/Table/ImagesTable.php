<?php
namespace App\Model\Table;

use App\Model\Entity\Image;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use ArrayObject;

/**
 * Images Model
 *
 * @property \Cake\ORM\Association\HasMany $Layouts
 */
class ImagesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('images');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Layouts', [
            'foreignKey' => 'image_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('filename', 'create')
            ->notEmpty('filename')
            ->add('filename', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('original_filename', 'create')
            ->notEmpty('original_filename');

        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data)
    {
        // Check if file was uploaded.
        if ($data->offsetExists('file')) {
            // save file and prepare data
            $file = $data->offsetGet('file');
            $filename = $this->generateFilename($file['name']);
            $dir = WWW_ROOT . Image::UPLOAD_DIR;
            $tmpFile = $file['tmp_name'];
            $newFile = $dir . DIRECTORY_SEPARATOR . $filename;
            move_uploaded_file($tmpFile, $newFile);
            $data->offsetSet('filename', $filename);
            $data->offsetSet('original_filename', $file['name']);
            $data->offsetUnset('file');
        }
    }

    protected function generateFilename($filename)
    {
        $hash = time();
        $hash .= md5($filename);
        return $hash;
    }

    public function afterFind($result, $primary = false)
    {
        if (array_key_exists(0, $result)) {
            // wiele wpisów
            foreach ($result as $key => $file) {
                $result[$key]['File']['url'] = FULL_BASE_URL . DIRECTORY_SEPARATOR .
                    'uploadFiles' . DIRECTORY_SEPARATOR . $file['File']['filename'];
            }
        } else {
            // Tylko 1 wynik
            $result['url'] = FULL_BASE_URL . DIRECTORY_SEPARATOR . 'uploadFiles' .
                DIRECTORY_SEPARATOR . $result['filename'];
        }
        return $result;
    }
}
