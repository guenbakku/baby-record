<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DishesMealActivities Model
 *
 * @property \App\Model\Table\DishesTable|\Cake\ORM\Association\BelongsTo $Dishes
 * @property \App\Model\Table\MealActivitiesTable|\Cake\ORM\Association\BelongsTo $MealActivities
 *
 * @method \App\Model\Entity\DishesMealActivity get($primaryKey, $options = [])
 * @method \App\Model\Entity\DishesMealActivity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DishesMealActivity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DishesMealActivity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DishesMealActivity saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DishesMealActivity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DishesMealActivity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DishesMealActivity findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DishesMealActivitiesTable extends Table
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

        $this->setTable('dishes_meal_activities');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Dishes', [
            'foreignKey' => 'dish_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('MealActivities', [
            'foreignKey' => 'meal_activity_id',
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
        $rules->add($rules->existsIn(['dish_id'], 'Dishes'));
        $rules->add($rules->existsIn(['meal_activity_id'], 'MealActivities'));

        return $rules;
    }
}
