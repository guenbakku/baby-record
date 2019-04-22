<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Babies Model
 *
 * @property \App\Model\Table\BottleMilkTable|\Cake\ORM\Association\HasMany $BottleMilk
 * @property \App\Model\Table\BreastMilkTable|\Cake\ORM\Association\HasMany $BreastMilk
 * @property \App\Model\Table\CustomTable|\Cake\ORM\Association\HasMany $Custom
 * @property \App\Model\Table\DiapersTable|\Cake\ORM\Association\HasMany $Diapers
 * @property \App\Model\Table\PumpMilkTable|\Cake\ORM\Association\HasMany $PumpMilk
 * @property \App\Model\Table\TemperatureTable|\Cake\ORM\Association\HasMany $Temperature
 *
 * @method \App\Model\Entity\Baby get($primaryKey, $options = [])
 * @method \App\Model\Entity\Baby newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Baby[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Baby|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Baby saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Baby patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Baby[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Baby findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BabiesTable extends Table
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

        $this->setTable('babies');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('BottleMilk', [
            'foreignKey' => 'baby_id',
            'dependent' => true
        ]);
        $this->hasMany('BreastMilk', [
            'foreignKey' => 'baby_id',
            'dependent' => true
        ]);
        $this->hasMany('Custom', [
            'foreignKey' => 'baby_id',
            'dependent' => true
        ]);
        $this->hasMany('Diapers', [
            'foreignKey' => 'baby_id',
            'dependent' => true
        ]);
        $this->hasMany('PumpMilk', [
            'foreignKey' => 'baby_id',
            'dependent' => true
        ]);
        $this->hasMany('Temperature', [
            'foreignKey' => 'baby_id',
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
            ->scalar('name')
            ->maxLength('name', 64)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->date('birthday')
            ->requirePresence('birthday', 'create')
            ->allowEmptyDate('birthday', false);

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
        $rules->add($rules->isUnique(['name']));
        return $rules;
    }
}
