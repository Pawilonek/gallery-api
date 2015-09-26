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
     * This function generate absolute path to image
     *
     * @return string
     */
    protected function _getAbsoluteUrl()
    {
        // get current host, with http/https
        $url = Router::url('/', true);
        // get upload dir
        $url .= self::UPLOAD_DIR . "/";
        // get filename
        $url .= $this->_properties['filename'];
        // return absolute path
        return $url;
    }
}
