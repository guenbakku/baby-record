<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Baby Entity
 *
 * @property string $id
 * @property string $name
 * @property \Cake\I18n\FrozenDate $birthday
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\BottleMilk[] $bottle_milk
 * @property \App\Model\Entity\BreastMilk[] $breast_milk
 * @property \App\Model\Entity\Custom[] $custom
 * @property \App\Model\Entity\Diaper[] $diapers
 * @property \App\Model\Entity\DumpMilk[] $dump_milk
 * @property \App\Model\Entity\Temperature[] $temperature
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
        'name' => true,
        'birthday' => true,
        'created' => true,
        'modified' => true,
        'bottle_milk' => true,
        'breast_milk' => true,
        'custom' => true,
        'diapers' => true,
        'dump_milk' => true,
        'temperature' => true
    ];
}
