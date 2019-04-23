<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BottleMilkActivities Model
 *
 * @property \App\Model\Table\ActivitiesTable|\Cake\ORM\Association\BelongsTo $Activities
 *
 * @method \App\Model\Entity\BottleMilkActivity get($primaryKey, $options = [])
 * @method \App\Model\Entity\BottleMilkActivity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BottleMilkActivity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BottleMilkActivity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BottleMilkActivity saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BottleMilkActivity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BottleMilkActivity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BottleMilkActivity findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BottleMilkActivitiesTable extends Table
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

        $this->setTable('bottle_milk_activities');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Activities', [
            'foreignKey' => 'activity_id',
            'joinType' => 'INNER'
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
            ->uuid('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->integer('duration')
            ->requirePresence('duration', 'create')
            ->allowEmptyString('duration', false);

        $validator
            ->integer('breast_volume')
            ->requirePresence('breast_volume', 'create')
            ->allowEmptyString('breast_volume', false);

        $validator
            ->integer('fomular_volume')
            ->requirePresence('fomular_volume', 'create')
            ->allowEmptyString('fomular_volume', false);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['activity_id']));
        $rules->add($rules->existsIn(['activity_id'], 'Activities'));

        return $rules;
    }
}
