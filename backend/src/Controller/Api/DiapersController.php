<?php
namespace App\Controller\Api;

use Cake\Event\Event;

/**
 * Diapers Controller
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DiapersController extends AppController
{
    public function index()
    {
        $babyId = $this->request->getQuery('baby_id');
        if (!$babyId) {
            throw new BadRequestException(__('Query parameter `baby_id` is required.'));
        }

        $this->Crud->on('beforePaginate', function (Event $event) use ($babyId) {
            // Only get data of current baby.
            $query = $event->getSubject()->query;
            $query->where(['baby_id' => $babyId]);
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

    // Inheriting the rest of FriendOfCake/Crud's methods.
}
