<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Activity Entity
 *
 * @property string $id
 * @property int $activity_type_id
 * @property string $baby_id
 * @property \Cake\I18n\FrozenTime $started
 * @property string|null $memo
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ActivityType $activity_type
 * @property \App\Model\Entity\Baby $baby
 * @property \App\Model\Entity\BottleMilkActivity[] $bottle_milk_activity
 * @property \App\Model\Entity\BreastMilkActivity[] $breast_milk_activity
 * @property \App\Model\Entity\CustomActivity[] $custom_activity
 * @property \App\Model\Entity\DiaperActivity[] $diaper_activity
 * @property \App\Model\Entity\PumpMilkActivity[] $pump_milk_activity
 * @property \App\Model\Entity\TemperatureActivity[] $temperature_activity
 */
class Activity extends Entity
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
        'activity_type_id' => true,
        'baby_id' => true,
        'started' => true,
        'memo' => true,
        'created' => true,
        'modified' => true,
        'activity_type' => true,
        'baby' => true,
        'bottle_milk_activity' => true,
        'breast_milk_activity' => true,
        'custom_activity' => true,
        'diaper_activity' => true,
        'pump_milk_activity' => true,
        'temperature_activity' => true
    ];
}
