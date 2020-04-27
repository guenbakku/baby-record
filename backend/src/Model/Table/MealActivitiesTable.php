<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MealActivities Model
 *
 * @property \App\Model\Table\ActivitiesTable|\Cake\ORM\Association\BelongsTo $Activities
 * @property \App\Model\Table\MealStatusesTable|\Cake\ORM\Association\BelongsTo $MealStatuses
 * @property \App\Model\Table\DishesTable|\Cake\ORM\Association\BelongsToMany $Dishes
 * @property \App\Model\Table\FilesTable|\Cake\ORM\Association\BelongsToMany $Files
 *
 * @method \App\Model\Entity\MealActivity get($primaryKey, $options = [])
 * @method \App\Model\Entity\MealActivity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MealActivity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MealActivity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MealActivity saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MealActivity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MealActivity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MealActivity findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MealActivitiesTable extends Table
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

        $this->setTable('meal_activities');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Activities', [
            'foreignKey' => 'activity_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('MealStatuses', [
            'foreignKey' => 'meal_status_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsToMany('Dishes', [
            'foreignKey' => 'meal_activity_id',
            'targetForeignKey' => 'dish_id',
            'joinTable' => 'dishes_meal_activities'
        ]);
        $this->belongsToMany('Files', [
            'foreignKey' => 'meal_activity_id',
            'targetForeignKey' => 'file_id',
            'joinTable' => 'files_meal_activities'
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
        $rules->add($rules->existsIn(['activity_id'], 'Activities'));
        $rules->add($rules->existsIn(['meal_status_id'], 'MealStatuses'));

        return $rules;
    }
}
