<?php
namespace App\Model\Entity;

use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use Guenbakku\Middleware\Http\ClientTimezoneMiddleware;

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
        'activity_type_id' => false,
        'baby_id' => true,
        'started' => true,
        'memo' => true,
        'created' => false,
        'modified' => false,
        'activity_type' => true,
        'baby' => true,
        'bottle_milk_activity' => true,
        'breast_milk_activity' => true,
        'custom_activity' => true,
        'diaper_activity' => true,
        'measurement_activity' => true,
        'pump_milk_activity' => true,
        'temperature_activity' => true
    ];

    /**
     * Convert value set to field 'started' to Cake\I18n\Time object
     * and set that timezone to the value of settings in server side.
     *
     * @param Any
     * @return \Cake\I18n\Time $time
     */
    protected function _setStarted($val)
    {
        if (!($val instanceof Time)) {
            $val = new Time($val, ClientTimezoneMiddleware::getClientTimezone());
        }
        $val->setTimezone(Configure::read('App.defaultTimezone'));
        return $val;
    }
}
