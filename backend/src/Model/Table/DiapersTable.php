<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Diapers Model
 *
 * @property \App\Model\Table\BabiesTable|\Cake\ORM\Association\BelongsTo $Babies
 *
 * @method \App\Model\Entity\Diaper get($primaryKey, $options = [])
 * @method \App\Model\Entity\Diaper newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Diaper[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Diaper|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Diaper saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Diaper patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Diaper[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Diaper findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DiapersTable extends Table
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

        $this->setTable('diapers');
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
            ->boolean('is_pee')
            ->requirePresence('is_pee', 'create')
            ->allowEmptyString('is_pee', false);

        $validator
            ->boolean('is_shit')
            ->requirePresence('is_shit', 'create')
            ->allowEmptyString('is_shit', false);

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
