<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;
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
        $this->Authentication->allowUnauthenticated(['token']);
    }

    /**
     * Return a JWT token to authenticated user
     *
     * @param   void
     */
    public function token()
    {
        $result = $this->Authentication->getResult();

        if (!$result->isValid()) {
            throw new UnauthorizedException(__('Invalid email or password'));
        }

        $userId = $this->Authentication->getIdentity()->getIdentifier();
        $this->HttpStatus->set('created');
        $this->set([
            'success' => true,
            'data' => [
                'token' => $this->genToken($userId),
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
        $userId = $this->Authentication->getIdentity()->getIdentifier();
        return $this->Crud->execute('View', ['id' => $userId]);
    }

    /**
     * Create a JWT token
     *
     * @param   string: user id
     * @return  string: token
     */
    protected function genToken($userId) {
        $service = $this->request->getAttribute('authentication');
        $jwtAuthenticator = $service->authenticators()->get('Jwt');
        $salt = $jwtAuthenticator->getConfig('secretKey');
        $algorithm = $jwtAuthenticator->getConfig('algorithms')[0];

        return JWT::encode(
            [
                'sub' => $userId,
                'exp' =>  time() + self::TOKEN_TIMEOUT,
            ],
            $salt,
            $algorithm
        );
    }
}
