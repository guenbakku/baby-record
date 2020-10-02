<?php
namespace App\Model\Behavior;

use Authentication\IdentityInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Table;

/**
 * UserIdSetter behavior
 */
class UserIdSetterBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    protected $_identity;

    public function setIdentity(IdentityInterface $identity)
    {
        $this->_identity = $identity;
    }

    public function getIdentity(): IdentityInterface
    {
        if ($this->_identity) {
            return $this->_identity;
        }

        throw new \BadFunctionCallException(
            'Please set identity before using it'
        );
    }

    public function beforeSave(
        \Cake\Event\Event $event,
        \Cake\Datasource\EntityInterface $entity,
        \ArrayObject $options)
    {
        // Auto set user_id to save data
        if ($entity->isNew()) {
            $identity = $this->getIdentity();
            $entity->user_id = $identity->getIdentifier();
        }
    }
}
