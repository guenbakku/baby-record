<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Diaper Entity
 *
 * @property string $id
 * @property string $baby_id
 * @property \Cake\I18n\FrozenTime $started
 * @property bool $is_pee
 * @property bool $is_shit
 * @property string|null $memo
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Baby $baby
 */
class Diaper extends Entity
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
        'is_pee' => true,
        'is_shit' => true,
        'memo' => true,
        'created' => true,
        'modified' => true,
        'baby' => true
    ];
}
