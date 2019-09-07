<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BottleMilkActivity Entity
 *
 * @property string $id
 * @property string $activity_id
 * @property int $duration
 * @property int $breast_volume
 * @property int $fomular_volume
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Activity $activity
 */
class BottleMilkActivity extends Entity
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
        'activity_id' => true,
        'duration' => true,
        'breast_volume' => true,
        'fomular_volume' => true,
        'created' => false,
        'modified' => false,
        'activity' => true
    ];

    protected $_virtual = ['total_volume'];

    protected function _getTotalVolume()
    {
        return $this->breast_volume + $this->fomular_volume;
    }
}
