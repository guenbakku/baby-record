<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DiaperActivities Model
 *
 * @property \App\Model\Table\ActivitiesTable|\Cake\ORM\Association\BelongsTo $Activities
 *
 * @method \App\Model\Entity\DiaperActivity get($primaryKey, $options = [])
 * @method \App\Model\Entity\DiaperActivity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DiaperActivity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DiaperActivity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DiaperActivity saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DiaperActivity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DiaperActivity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DiaperActivity findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DiaperActivitiesTable extends Table
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

        $this->setTable('diaper_activities');
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
            ->boolean('is_pee')
            ->requirePresence('is_pee', 'create')
            ->allowEmptyString('is_pee', false);

        $validator
            ->boolean('is_shit')
            ->requirePresence('is_shit', 'create')
            ->allowEmptyString('is_shit', false);

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
