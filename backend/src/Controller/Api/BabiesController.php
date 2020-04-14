<?php
namespace App\Controller\Api;

use Cake\Event\Event;

/**
 * Babies Controller
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BabiesController extends AppController
{
    public function index()
    {
        $this->Crud->on('beforePaginate', function (Event $event) {
            $userId = $this->Authentication->getIdentity()->getIdentifier();
            $query = $event->getSubject()->query;
            $query->where(['user_id' => $userId]);
        });

        return $this->Crud->execute();
    }

    public function add()
    {
        $this->Crud->on('beforeSave', function (Event $event) {
            $entity = $event->getSubject()->entity;
            if (empty($entity->getErrors())) {
                $entity->user_id = $this->Authentication->getIdentity()->getIdentifier();
            }
        });

        return $this->Crud->execute();
    }

    public function edit()
    {
        $this->Crud->on('beforeSave', function (Event $event) {
            $entity = $event->getSubject()->entity;
            if (empty($entity->getErrors())) {
                $entity->user_id = $this->Authentication->getIdentity()->getIdentifier();
            }
        });

        return $this->Crud->execute();
    }

    // Inheriting the rest of FriendOfCake/Crud's methods.
}
