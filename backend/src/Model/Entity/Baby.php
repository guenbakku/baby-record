<?php
namespace App\Model\Entity;

use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use Guenbakku\Middleware\Http\ClientTimezoneMiddleware;

/**
 * Baby Entity
 *
 * @property string $id
 * @property string $name
 * @property \Cake\I18n\FrozenDate $birthday
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Activities[] $activities
 */
class Baby extends Entity
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
        'user_id' => true,
        'name' => true,
        'birthday' => true,
        'sex_id' => true,
        'created' => false,
        'modified' => false,
        'activities' => true
    ];

    /**
     * Convert value set to field 'birthday' to Cake\I18n\Time object
     * and set that timezone to the value of settings in server side.
     *
     * @param Any
     * @return \Cake\I18n\Time $time
     */
    protected function _setBirthday($val)
    {
        if (!($val instanceof Time)) {
            $val = new Time($val, ClientTimezoneMiddleware::getClientTimezone());
        }
        $val->setTimezone(Configure::read('App.defaultTimezone'));
        return $val;
    }
}
