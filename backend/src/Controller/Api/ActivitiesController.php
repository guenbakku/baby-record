<?php
namespace App\Controller\Api;

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Http\Exception\BadRequestException;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Utility\Hash;
use Guenbakku\Middleware\Http\ClientTimezoneMiddleware;

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
            $query->contain(array_merge($activityTypeTables, [
                'ActivityTypes',
                'MealActivities' => ['MealStatuses', 'Dishes', 'Files']
            ]));

            // Create search conditions
            $query = $this->genIndexConditions($query);
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
                $entity->activity_type_id = $this->detectActivityType($entity)->id;
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
            $query->contain(array_merge($activityTypeTables, [
                'ActivityTypes',
                'MealActivities' => ['MealStatuses', 'Dishes', 'Files']
            ]));
        });

        return $this->Crud->execute();
    }

    public function edit()
    {
        $this->Crud->on('beforeSave', function (Event $event) {
            $activityId = $this->request->getParam('id');
            $entity = $event->getSubject()->entity;

            // Insert id of sub activity record
            $activityType = $this->detectActivityType($entity);
            $subActivitiesTb = TableRegistry::getTableLocator()->get($activityType->tableName);
            $subActivity = $subActivitiesTb->find()
                ->select('id')
                ->where(['activity_id' => $activityId])
                ->first();
            if ($subActivity) {
                $entity->{$activityType->code}->id = $subActivity->id;
            }
        });

        return $this->Crud->execute();
    }

    /**
     * Generate search conditions for index method
     *
     * @param Query $query
     * @return Query
     */
    protected function genIndexConditions($query)
    {
        $val = Hash::get($this->request->getQuery(), 'filter.from');
        if (!in_array($val, [null, ''], true)) {
            $val = new Time($val, ClientTimezoneMiddleware::getClientTimezone());
            $val->setTimezone(Configure::read('App.defaultTimezone'));
            $query->where(['started >=' => $val]);
        }

        $val = Hash::get($this->request->getQuery(), 'filter.to');
        if (!in_array($val, [null, ''], true)) {
            $val = new Time($val, ClientTimezoneMiddleware::getClientTimezone());
            $val->setTimezone(Configure::read('App.defaultTimezone'));
            $query->where(['started <=' => $val]);
        }

        return $query;
    }

    /**
     * Auto detect activity_type_id of one activity data
     *
     * @param Entity $entity
     * @return Entity $activityType
     * @throws \Cake\Http\Exception\BadRequestException
     */
    protected function detectActivityType(\Cake\ORM\Entity $entity)
    {
        $activityTypesTb = TableRegistry::getTableLocator()->get('ActivityTypes');
        $activityTypes = $activityTypesTb->find()
            ->select(['id', 'code']);

        foreach ($activityTypes as $activityType) {
            $code = $activityType->code;
            if (isset($entity->{$code})) {
                return $activityType;
            }
        }

        throw new BadRequestException(__('Could not detect activity type'));
    }
}
