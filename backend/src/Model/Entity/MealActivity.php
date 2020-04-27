<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MealActivity Entity
 *
 * @property string $id
 * @property string $activity_id
 * @property int $meal_status_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Activity $activity
 * @property \App\Model\Entity\MealStatus $meal_status
 * @property \App\Model\Entity\Dish[] $dishes
 * @property \App\Model\Entity\File[] $files
 */
class MealActivity extends Entity
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
        'meal_status_id' => true,
        'created' => false,
        'modified' => false,
        'activity' => true,
        'meal_status' => true,
        'dishes' => true,
        'files' => true
    ];
}
