<?php
namespace App\Controller\Api;

use Cake\Event\Event;
use Cake\Http\Exception\InternalErrorException;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Crud\Error\Exception\ValidationException;
use Zend\Diactoros\Stream;

/**
 * Files Controller
 *
 * @property \App\Model\Table\FilesTable $Files
 *
 * @method \App\Model\Entity\File[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesController extends AppController
{
    public function index()
    {
        $this->Crud->on('beforePaginate', function (Event $event) {
            $userId = $this->Authentication->getIdentity()->getIdentifier();
            $query = $event->getSubject()->query;
            $query
                ->where(['user_id' => $userId])
                ->order(['created' => 'asc']);
        });

        return $this->Crud->execute();
    }

    // public function add()
    // {
    //     // Pass identity into table object to use in its event
    //     $identity = $this->Authentication->getIdentity();
    //     TableRegistry::getTableLocator()->get('Files')->setIdentity($identity);

    //     $this->Crud->on('beforeSave', function (Event $event) {
    //         $meta = $this->Files->saveRawInputToStorage();
    //         $event->getSubject()->entity = $meta;
    //     });
    //     return $this->Crud->execute();
    // }

    public function upload()
    {
        $filesTb = TableRegistry::getTableLocator()->get('Files');
        $entity = $filesTb->saveRawInputToTemporaryStorage();

        if ($entity->errors()) {
            throw new ValidationException($entity);
        }

        $this->HttpStatus->set('created');
        $this->set([
            'success' => true,
            'data' => $entity->toArray(),
            '_serialize' => ['success', 'data'],
        ]);
    }

    public function download($fileId)
    {
        $userId = $this->Authentication->getIdentity()->getIdentifier();

        $filesTb = TableRegistry::getTableLocator()->get('Files');
        $file = $filesTb->find()
            ->where([
                'id' => $fileId,
                'user_id' => $userId
            ])
            ->first();

        if (!$file) {
            throw new NotFoundException();
        }

        $resource = $filesTb->getFileResourceFromStorage($file->path);
        if (!$resource) {
            throw new InternalErrorException('Could not get file resource');
        }

        $this->HttpStatus->set('ok');
        $response = $this->response
            ->withBody(new Stream($resource))
            ->withType($file->mime_type)
            ->withDownload(basename($file->path));

        return $response;
    }
}
