<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;

/**
 * ActivityTypes Model
 *
 * @property \App\Model\Table\ActivitiesTable|\Cake\ORM\Association\HasMany $Activities
 *
 * @method \App\Model\Entity\ActivityType get($primaryKey, $options = [])
 * @method \App\Model\Entity\ActivityType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ActivityType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ActivityType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivityType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivityType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ActivityType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ActivityType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ActivityTypesTable extends Table
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

        $this->setTable('activity_types');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Activities', [
            'foreignKey' => 'activity_type_id'
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

    public function getCodes()
    {
        return $this->find()
            ->select(['id', 'code'])
            ->map(function (\Cake\ORM\Entity $entity) {
                return $entity->code;
            })
            ->toArray();
    }

    public function getTableNames()
    {
        return $this->find()
            ->select(['id', 'code'])
            ->map(function (\Cake\ORM\Entity $entity) {
                return Inflector::camelize(Inflector::pluralize($entity->code));
            })
            ->toArray();
    }
}
