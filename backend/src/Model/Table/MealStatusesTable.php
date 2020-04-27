<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MealStatuses Model
 *
 * @property \App\Model\Table\MealActivitiesTable|\Cake\ORM\Association\HasMany $MealActivities
 *
 * @method \App\Model\Entity\MealStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\MealStatus newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MealStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MealStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MealStatus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MealStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MealStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MealStatus findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MealStatusesTable extends Table
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

        $this->setTable('meal_statuses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('MealActivities', [
            'foreignKey' => 'meal_status_id'
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
