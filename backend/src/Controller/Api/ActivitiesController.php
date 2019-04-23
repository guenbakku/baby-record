<?php
namespace App\Controller\Api;

use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Http\Exception\BadRequestException;
use Cake\ORM\TableRegistry;

/**
 * Activities Controller
 *
 * @method \App\Model\Entity\Activity[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ActivitiesController extends AppController
{
    public function index()
    {
        $babyId = $this->request->getQuery('baby_id');
        if (!$babyId) {
            throw new BadRequestException(__('Query parameter `baby_id` is required.'));
        }

        $this->Crud->on('beforePaginate', function (Event $event) use ($babyId) {
            $query = $event->getSubject()->query;

            // Only get data of current baby.
            $query->where(['baby_id' => $babyId]);

            // Also contain sub activity tables
            $activityTypesTb = TableRegistry::getTableLocator()->get('ActivityTypes');
            $activityTypeTables = $activityTypesTb->getTableNames();
            $query->contain(array_merge($activityTypeTables, ['ActivityTypes']));
        });

        return $this->Crud->execute();
    }

    public function add()
    {
        $babyId = $this->request->getQuery('baby_id');
        if (!$babyId) {
            throw new BadRequestException(__('Query parameter `baby_id` is required.'));
        }

        $this->Crud->on('beforeSave', function (Event $event) use ($babyId) {
            $entity = $event->getSubject()->entity;
            if (empty($entity->getErrors())) {
                $entity->baby_id = $babyId;
            }
        });

        return $this->Crud->execute();
    }

    public function view()
    {
        $this->Crud->on('beforeFind', function (Event $event) {
            $query = $event->getSubject()->query;

            // Also contain sub activity tables
            $activityTypesTb = TableRegistry::getTableLocator()->get('ActivityTypes');
            $activityTypeTables = $activityTypesTb->getTableNames();
            $query->contain(array_merge($activityTypeTables, ['ActivityTypes']));
        });

        return $this->Crud->execute();
    }

    public function edit()
    {
        $this->Crud->on('beforeSave', function (Event $event) {
            $activityTypesTb = TableRegistry::getTableLocator()->get('ActivityTypes');
            $activityTypeCodes = $activityTypesTb->getCodes();
            $mustClean = false;
            foreach ($activityTypeCodes as $field) {
                if (isset($event->getSubject()->entity->{$field})) {
                    $mustClean = true;
                    break;
                }
            }

            // Delete all sub records of current activity
            if ($mustClean) {
                $conn = ConnectionManager::get('default');
                $conn->transactional(function ($conn) use ($activityTypesTb) {
                    $activityId = $this->request->getParam('id');
                    $activityTypeTables = $activityTypesTb->getTableNames();

                    foreach ($activityTypeTables as $tableName) {
                        $table = TableRegistry::getTableLocator()->get($tableName);
                        $table->deleteAll(['activity_id' => $activityId]);
                    }
                });
            }
        });

        return $this->Crud->execute();
    }

    // Inheriting the rest of FriendOfCake/Crud's methods.
}
