<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Firebase\JWT\JWT;

/**
 * Users Controller
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    const TOKEN_TIMEOUT = 15552000; // 180 days in seconds

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['token']);
    }

    /**
     * Return a JWT token to authenticated user
     *
     * @param   void
     */
    public function token()
    {
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException(__('Invalid email or password'));
        }

        $this->HttpStatus->set('created');
        $this->set([
            'success' => true,
            'data' => [
                'token' => $this->genToken($user['id']),
            ],
            '_serialize' => ['success', 'data'],
        ]);
    }

    /**
     * Return info of current logged in user
     *
     * @param   void
     */
    public function me()
    {
        $userId = $this->Auth->user('id');
        return $this->Crud->execute('View', ['id' => $userId]);
    }

    /**
     * Create a JWT token
     *
     * @param   string: user id
     * @return  string: token
     */
    protected function genToken($userId) {
        $salt = Configure::read('Security.jwtSalt');
        return JWT::encode([
            'sub' => $userId,
            'exp' =>  time() + self::TOKEN_TIMEOUT,
        ], $salt);
    }
}
