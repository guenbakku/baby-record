<?php

use Cake\Http\Exception\UnauthorizedException;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use CakeDC\Auth\Rbac\Rules\Owner;

return [
    'CakeDC/Auth.permissions' => [
        //specific actions allowed for the all roles in Users plugin
        [
            'role' => '*',
            'plugin' => false,
            'prefix' => 'Api',
            'controller' => 'Users',
            'action' => ['token'],
            'bypassAuth' => true
        ],
        [
            'role' => 'user',
            'plugin' => false,
            'prefix' => 'Api',
            'controller' => 'Users',
            'action' => '*',
            'allowed' => true
        ],
        [
            'role' => 'user',
            'plugin' => false,
            'prefix' => 'Api',
            'controller' => 'Babies',
            'action' => ['index', 'add'],
            'allowed' => true
        ],
        [
            'role' => 'user',
            'plugin' => false,
            'prefix' => 'Api',
            'controller' => 'Babies',
            'action' => ['edit', 'view', 'delete'],
            'allowed' => new Owner()
        ],
        [
            'role' => 'user',
            'plugin' => false,
            'prefix' => 'Api',
            'controller' => 'Activities',
            'action' => ['index', 'add'],
            'allowed' => new Owner([
                'tableKeyType' => Owner::TYPE_TABLE_KEY_QUERY,
                'tableIdParamsKey' => 'baby_id',
                'table' => 'Babies',
                'ownerForeignKey' => 'user_id'
            ])
        ],
        [
            'role' => 'user',
            'plugin' => false,
            'prefix' => 'Api',
            'controller' => 'Activities',
            'action' => ['view', 'edit', 'delete'],
            'allowed' => function (array $user, $role, \Cake\Http\ServerRequest $request) {
                $userId = Hash::get($user, 'id');
                $activityId = Hash::get($request->getAttribute('params'), 'pass.0');
                $table = TableRegistry::getTableLocator()->get('Activities');
                $query = $table->find()
                    ->select(['exist' => 1])
                    ->where(['Activities.id' => $activityId])
                    ->matching('Babies', function ($q) use ($userId) {
                        return $q->where(['Babies.user_id' => $userId]);
                    })
                    ->limit(1);

                return (bool) count($query->enableHydration(false)->toArray());
            }
        ],
        [
            'role' => 'user',
            'plugin' => false,
            'prefix' => 'Api',
            'controller' => 'Codes',
            'action' => ['view'],
            'bypassAuth' => true
        ],

        // Fallback rule to raise UnauthenticatedException for the case
        // that there is not any matched rule (= user is not authenticated).
        [
            'role' => '*',
            'plugin' => '*',
            'prefix' => '*',
            'controller' => '*',
            'action' => '*',
            'allowed' => function (array $user, $role, \Cake\Http\ServerRequest $request) {
                throw new UnauthorizedException('Authentication is required to continue');
            }
        ],
    ]
];
