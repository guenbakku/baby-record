<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BottleMilk Entity
 *
 * @property string $id
 * @property string $baby_id
 * @property \Cake\I18n\FrozenTime $started
 * @property int $duration
 * @property int $breast_volume
 * @property int $fomular_volume
 * @property string|null $memo
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Baby $baby
 */
class BottleMilk extends Entity
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
        'baby_id' => true,
        'started' => true,
        'duration' => true,
        'breast_volume' => true,
        'fomular_volume' => true,
        'memo' => true,
        'created' => true,
        'modified' => true,
        'baby' => true
    ];

    /**
     * Virtual fields that will be exposed in json/xml
     *
     * @var array
     */
    protected $_virtual = ['title', 'total_volume'];

    protected function _getTitle()
    {
        return __('Bottle milk');
    }

    protected function _getTotalVolume()
    {
        return $this->breast_volume + $this->fomular_volume;
    }
}
