<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * Image Entity.
 *
 * @property int $id
 * @property string $filename
 * @property string $original_filename
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Layout[] $layouts
 */
class Image extends Entity
{

    const UPLOAD_DIR = 'uploadedImages';

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected $_virtual = ['absolute_url'];

    /**
     * Funkcja odpowiedzialna za wygenerowanie absolutnego adresu do obrazka.
     *
     * @return string
     */
    protected function _getAbsoluteUrl()
    {
        // pobranie adresu url aktualnej strony wraz protokołem http / https
        $url = Router::url('/', true);
        // dodanie do adresu katalogu z przesłanymi obrazkami
        $url .= self::UPLOAD_DIR . "/";
        // dodanie do adresu nazwy aktualnego pliku
        $url .= $this->_properties['filename'];
        // zarócenie adresu
        return $url;
    }
}
