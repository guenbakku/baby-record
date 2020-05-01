<?php
namespace App\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\Entity;

/**
 * File Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $path
 * @property string $content_type
 * @property int $size
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\MealActivity[] $meal_activities
 */
class File extends Entity
{
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
        'user_id' => false,
        'path' => true,
        'mime_type' => true,
        'size' => true,
        'created' => false,
        'modified' => false,
        'user' => true,
        'meal_activities' => true
    ];

    /**
     * Virtual fields that should be included to JSON
     */
    protected $_virtual = ['url'];

    /**
     * Return url to download current file
     *
     * @param   void
     * @return  string
     */
    protected function _getUrl()
    {
        if ($this->id) {
            return implode('/', [
                trim(Configure::read('App.fullBaseUrl'), '/'),
                'files/download',
                $this->id
            ]);
        }

        return null;
    }

    protected function _getTemporaryPath()
    {
        return implode('/', [
            trim(Configure::read('Storage.prefix.temporary'), '/'),
            $this->path
        ]);
    }

    protected function _getPersistentPath()
    {
        return implode('/', [
            trim(Configure::read('Storage.prefix.persistent'), '/'),
            $this->path
        ]);
    }
}
