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

    /**
     * Metoda odpowiedzialna za zapisanie pliku na serwerze
     *
     * @param Event $event
     * @param ArrayObject $data
     */
    public function beforeMarshal(Event $event, ArrayObject $data)
    {
        // Sprawdzenie czy jakiś plik został przesłany
        if ($data->offsetExists('file')) {
            // pobranie nazwy przesłanego pliku
            $file = $data->offsetGet('file');
            // wygenerowanie nowej nazwy pliku
            $filename = $this->generateFilename($file['name']);
            // zapisanie przeslanego pliku na serwerze
            $dir = WWW_ROOT . Image::UPLOAD_DIR;
            $tmpFile = $file['tmp_name'];
            $newFile = $dir . DIRECTORY_SEPARATOR . $filename;
            move_uploaded_file($tmpFile, $newFile);
            // zapisanie nowych danych
            $data->offsetSet('filename', $filename);
            $data->offsetSet('original_filename', $file['name']);
            $data->offsetUnset('file');
        }
    }

    /**
     * Metoda odpowiedzialna za wygenerowanie
     * unikalnej nazyw pliku używanej w systemie
     *
     * @param string $filename
     * @return string
     */
    protected function generateFilename($filename)
    {
        // wygenerowanie początku nazwy pliku
        // na podstawie aktualnego czasu
        $hash = time();
        // dodanie do nazyw pliku hashu mp5 z nazwy pliku
        $hash .= md5($filename);
        // zwrócenie nowej nazwy pliku
        return $hash;
    }

}
