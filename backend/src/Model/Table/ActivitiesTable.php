<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Activities Model
 *
 * @property \App\Model\Table\ActivityTypesTable|\Cake\ORM\Association\BelongsTo $ActivityTypes
 * @property \App\Model\Table\BabiesTable|\Cake\ORM\Association\BelongsTo $Babies
 * @property \App\Model\Table\BottleMilkActivitiesTable|\Cake\ORM\Association\hasOne $BottleMilkActivities
 * @property \App\Model\Table\BreastMilkActivitiesTable|\Cake\ORM\Association\hasOne $BreastMilkActivities
 * @property \App\Model\Table\CustomActivitiesTable|\Cake\ORM\Association\hasOne $CustomActivities
 * @property \App\Model\Table\DiaperActivitiesTable|\Cake\ORM\Association\hasOne $DiaperActivities
 * @property \App\Model\Table\PumpMilkActivitiesTable|\Cake\ORM\Association\hasOne $PumpMilkActivities
 * @property \App\Model\Table\TemperatureActivitiesTable|\Cake\ORM\Association\hasOne $TemperatureActivities
 *
 * @method \App\Model\Entity\Activity get($primaryKey, $options = [])
 * @method \App\Model\Entity\Activity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Activity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Activity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Activity saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Activity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Activity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Activity findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ActivitiesTable extends Table
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

        $this->setTable('activities');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ActivityTypes', [
            'foreignKey' => 'activity_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Babies', [
            'foreignKey' => 'baby_id',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('BottleMilkActivities', [
            'foreignKey' => 'activity_id',
            'dependent' => true
        ]);
        $this->hasOne('BreastMilkActivities', [
            'foreignKey' => 'activity_id',
            'dependent' => true
        ]);
        $this->hasOne('CustomActivities', [
            'foreignKey' => 'activity_id',
            'dependent' => true
        ]);
        $this->hasOne('DiaperActivities', [
            'foreignKey' => 'activity_id',
            'dependent' => true
        ]);
        $this->hasOne('PumpMilkActivities', [
            'foreignKey' => 'activity_id',
            'dependent' => true
        ]);
        $this->hasOne('TemperatureActivities', [
            'foreignKey' => 'activity_id',
            'dependent' => true
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
            ->dateTime('started')
            ->requirePresence('started', 'create')
            ->allowEmptyDateTime('started', false);

        $validator
            ->scalar('memo')
            ->maxLength('memo', 256)
            ->allowEmptyString('memo');

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
        $rules->add($rules->existsIn(['activity_type_id'], 'ActivityTypes'));
        $rules->add($rules->existsIn(['baby_id'], 'Babies'));

        return $rules;
    }
}
