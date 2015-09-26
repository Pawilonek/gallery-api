<?php
namespace App\Model\Table;

use App\Model\Entity\Gallery;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use ArrayObject;

/**
 * Galleries Model
 *
 * @property \Cake\ORM\Association\HasMany $Layouts
 */
class GalleriesTable extends Table
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

        $this->table('galleries');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Layouts', [
            'foreignKey' => 'gallery_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data)
    {
        // Check if we have gallery name
        if (!$data->offsetExists('name')) {
            return;
        }

        // Check if gallery name is string
        if (!is_string($data->offsetGet('name'))) {
            return;
        }

        // Generate slug
        $name = $data->offsetGet('name');
        $slug = $this->generateSlug($name);
        $data->offsetSet('slug', $slug);
    }

    protected function generateSlug($string)
    {
        $string = strtolower($string);
        $plCharset = array(
            ',',
            ' - ',
            ' ',
            'ę',
            'Ę',
            'ó',
            'Ó',
            'Ą',
            'ą',
            'Ś',
            'ś',
            'ł',
            'Ł',
            'ż',
            'Ż',
            'Ź',
            'ź',
            'ć',
            'Ć',
            'ń',
            'Ń',
            '-',
            "'",
            "/",
            "?",
            '"',
            ":",
            '!',
            '.',
            '&',
            '&amp;',
            '#',
            ';',
            '[',
            ']',
            '(',
            ')',
            '`',
            '%',
            '”',
            '„',
            '…');
        $international = array(
            '-',
            '-',
            '-',
            'e',
            'E',
            'o',
            'P',
            'A',
            'a',
            'S',
            's',
            'l',
            'L',
            'z',
            'Z',
            'z',
            'Z',
            'c',
            'C',
            'n',
            'N',
            '-',
            "",
            "",
            "",
            "",
            "",
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '');
        $string = str_replace($plCharset, $international, $string);

        $string = preg_replace('/[^0-9a-z\-]+/', '', $string);
        $string = preg_replace('/[\-]+/', '-', $string);
        $string = trim($string, '-');
        return $string;
    }
}
