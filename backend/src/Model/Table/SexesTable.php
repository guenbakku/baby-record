<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sexes Model
 *
 * @property \App\Model\Table\BabiesTable|\Cake\ORM\Association\HasMany $Babies
 *
 * @method \App\Model\Entity\Sex get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sex newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Sex[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sex|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sex saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sex patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sex[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sex findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SexesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('sexes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Babies', [
            'foreignKey' => 'sex_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('code')
            ->maxLength('code', 64)
            ->requirePresence('code', 'create')
            ->allowEmptyString('code', false);

        $validator
            ->scalar('label')
            ->maxLength('label', 64)
            ->requirePresence('label', 'create')
            ->allowEmptyString('label', false);

        $validator
            ->integer('sort_no')
            ->requirePresence('sort_no', 'create')
            ->allowEmptyString('sort_no', false);

        return $validator;
    }
}
