<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DumpMilk Model
 *
 * @property \App\Model\Table\BabiesTable|\Cake\ORM\Association\BelongsTo $Babies
 *
 * @method \App\Model\Entity\DumpMilk get($primaryKey, $options = [])
 * @method \App\Model\Entity\DumpMilk newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DumpMilk[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DumpMilk|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DumpMilk saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DumpMilk patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DumpMilk[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DumpMilk findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DumpMilkTable extends Table
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

        $this->setTable('dump_milk');
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
            ->integer('volume')
            ->requirePresence('volume', 'create')
            ->allowEmptyString('volume', false);

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
