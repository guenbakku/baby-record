<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller\Api;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Crud\Error\Exception\ValidationException;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    use \Crud\Controller\ControllerTrait;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);

        $this->loadComponent('RequireAcceptHeader', [
            'requires' => ['application/json'],
        ]);

        $this->loadComponent('HttpStatus');

        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Delete' => [
                    'className' => 'Crud.Delete',
                    'api' => [
                        'error' => [
                            'exception' => [
                                'type' => 'validate',
                                'class' => ValidationException::class
                            ]
                        ]
                    ]
                ]
            ],
            'listeners' => array_merge(
                [
                    'Crud.Api',
                    'Crud.RelatedModels',
                    'Crud.ApiPagination',
                ],
                Configure::read('debug') ? ['Crud.ApiQueryLog'] : []
            )
        ]);

        $this->loadComponent('Auth', [
            'storage' => 'Memory',
            'authenticate' => [
                'all' => [
                    ['userModel' => 'Users']
                ],
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password',
                    ]
                ],
                'ADmad/JwtAuth.Jwt' => [
                    'fields' => [
                        'username' => 'id'
                    ],
                    'parameter' => 'token',
                    'queryDatasource' => true,
                    'key' => Configure::read('Security.jwtSalt'),
                ]
            ],
            'unauthorizedRedirect' => false,
            'checkAuthIn' => 'Controller.initialize',
            // If you don't have a login action in your application set
            // 'loginAction' to false to prevent getting a MissingRouteException.
            'loginAction' => false
        ]);
    }

    /**
     * beforeFilter hook method.
     *
     * @param \Cake\Event\Event $event event
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        // Set default config for paginator
        $this->paginate = [
            'page' => 1,
            'limit' => 50,
            'maxLimit' => 200,
        ];
    }
}
