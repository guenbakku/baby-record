<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Custom Entity
 *
 * @property string $id
 * @property string $baby_id
 * @property string $title
 * @property string|null $memo
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Baby $baby
 */
class Custom extends Entity
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
        'title' => true,
        'memo' => true,
        'created' => true,
        'modified' => true,
        'baby' => true
    ];
}
