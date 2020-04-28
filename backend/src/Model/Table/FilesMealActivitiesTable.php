<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FilesMealActivities Model
 *
 * @property \App\Model\Table\FilesTable|\Cake\ORM\Association\BelongsTo $Files
 * @property \App\Model\Table\MealActivitiesTable|\Cake\ORM\Association\BelongsTo $MealActivities
 *
 * @method \App\Model\Entity\FilesMealActivity get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilesMealActivity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FilesMealActivity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilesMealActivity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesMealActivity saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesMealActivity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilesMealActivity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilesMealActivity findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FilesMealActivitiesTable extends Table
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

        $this->setTable('files_meal_activities');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Files', [
            'foreignKey' => 'file_id',
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
        $rules->add($rules->existsIn(['file_id'], 'Files'));
        $rules->add($rules->existsIn(['meal_activity_id'], 'MealActivities'));

        return $rules;
    }
}