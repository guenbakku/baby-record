<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sex Entity
 *
 * @property int $id
 * @property string $code
 * @property string $label
 * @property int $sort_no
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Baby[] $babies
 */
class Sex extends Entity
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
        'code' => true,
        'label' => true,
        'sort_no' => true,
        'created' => false,
        'modified' => false,
        'babies' => true
    ];
}
