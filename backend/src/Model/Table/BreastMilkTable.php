<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BreastMilk Model
 *
 * @property \App\Model\Table\BabiesTable|\Cake\ORM\Association\BelongsTo $Babies
 *
 * @method \App\Model\Entity\BreastMilk get($primaryKey, $options = [])
 * @method \App\Model\Entity\BreastMilk newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BreastMilk[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BreastMilk|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BreastMilk saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BreastMilk patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BreastMilk[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BreastMilk findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BreastMilkTable extends Table
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

        $this->setTable('breast_milk');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Babies', [
            'foreignKey' => 'baby_id',
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
            ->dateTime('started')
            ->requirePresence('started', 'create')
            ->allowEmptyDateTime('started', false);

        $validator
            ->integer('duration')
            ->requirePresence('duration', 'create')
            ->allowEmptyString('duration', false);

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
        $rules->add($rules->existsIn(['baby_id'], 'Babies'));

        return $rules;
    }
}
