<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DishesMealActivity Entity
 *
 * @property string $id
 * @property string $dish_id
 * @property string $meal_activity_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Dish $dish
 * @property \App\Model\Entity\MealActivity $meal_activity
 */
class DishesMealActivity extends Entity
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
        'dish_id' => true,
        'meal_activity_id' => true,
        'created' => false,
        'modified' => false,
        'dish' => false,
        'meal_activity' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'created',
        'modified'
    ];
}
