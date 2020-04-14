<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomActivity Entity
 *
 * @property string $id
 * @property string $activity_id
 * @property string $title
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Activity $activity
 */
class CustomActivity extends Entity
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
        'title' => true,
        'created' => false,
        'modified' => false,
        'activity' => true
    ];
}
