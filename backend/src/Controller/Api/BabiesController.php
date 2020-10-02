<?php
namespace App\Controller\Api;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;

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
        // Pass identity into table object to use in its event
        TableRegistry::getTableLocator()->get('Babies')
            ->setIdentity($this->Authentication->getIdentity());

        return $this->Crud->execute();
    }

    public function edit()
    {
        // Pass identity into table object to use in its event
        TableRegistry::getTableLocator()->get('Babies')
            ->setIdentity($this->Authentication->getIdentity());

        return $this->Crud->execute();
    }

    // Inheriting the rest of FriendOfCake/Crud's methods.
}
