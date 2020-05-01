<?php
namespace App\Model\Table;

use App\Utility\Flysystem;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use Mimey\MimeTypes;

/**
 * Files Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\MealActivitiesTable|\Cake\ORM\Association\BelongsToMany $MealActivities
 *
 * @method \App\Model\Entity\File get($primaryKey, $options = [])
 * @method \App\Model\Entity\File newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\File[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\File|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\File saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\File patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\File[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\File findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FilesTable extends Table
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

        $this->setTable('files');
        $this->setDisplayField('path');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('UserIdSetter');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('MealActivities', [
            'foreignKey' => 'file_id',
            'targetForeignKey' => 'meal_activity_id',
            'joinTable' => 'files_meal_activities'
        ]);
        $this->hasMany('FilesMealActivities', [
            'foreignKey' => 'file_id',
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
            ->scalar('path')
            ->maxLength('path', 512)
            ->requirePresence('path', 'create')
            ->allowEmptyString('path', false);

        $validator
            ->scalar('mime_type')
            ->maxLength('mime_type', 64)
            ->requirePresence('mime_type', 'create')
            ->allowEmptyString('mime_type', false)
            ->inList(
                'mime_type',
                ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 'image/tiff'],
                __('You are not allowed to uploaded this type of file')
            );

        $validator
            ->integer('size')
            ->requirePresence('size', 'create')
            ->allowEmptyString('size', false)
            ->lessThanOrEqual(
                'size',
                10485760,
                __('Uploaded file is too large. Max is {0} MB', 10)
            );

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * Save php://input into file in storage.
     *
     * @param void
     * @return Entity meta info ([size, path, ...])
     */
    public function saveRawInputToTemporaryStorage()
    {
        // Write upload content to local disk to get meta info
        // before moving it to storage
        $stream = fopen('php://input', 'r+');
        $tmpfile = tmpfile();
        $tmppath = stream_get_meta_data($tmpfile)['uri'];
        file_put_contents($tmppath, $stream);
        fclose($stream);

        // Validate uploaded file
        // and move it to storage if there is not any error.
        $mimeType = mime_content_type($tmppath);
        $extension = (new MimeTypes)->getExtension($mimeType);
        $path = Text::uuid() . '.' . $extension;
        $meta = [
            'size' => filesize($tmppath),
            'mime_type' => $mimeType,
            'path' => $path,
        ];
        $entity = $this->newEntity($meta);
        if (!$entity->getErrors()) {
            $stream = fopen($tmppath, 'r+');
            $filesystem = Flysystem::getFilesystem();
            $filesystem->writeStream($entity->temporary_path, $stream);
            fclose($stream);
        }

        return $entity;
    }

    /**
     * Move file from temporary to persistent storage
     *
     * @param string $path
     * @return boolean
     */
    public function moveFileToPersistentStorage($path)
    {
        $meta = [
            'path' => $path,
        ];
        $entity = $this->newEntity($meta, ['validate' => false]);
        $filesystem = Flysystem::getFilesystem();
        $result = $filesystem->rename(
            $entity->temporary_path,
            $entity->persistentPath
        );

        return $result;
    }

    /**
     * Return file stream from storage
     *
     * @param string $savePath
     * @return resource|false stream to get file content
     */
    public function getFileResourceFromStorage(string $savePath)
    {
        $filesystem = Flysystem::getFilesystem();
        $resource = $filesystem->readStream($savePath);
        return $resource;
    }
}
