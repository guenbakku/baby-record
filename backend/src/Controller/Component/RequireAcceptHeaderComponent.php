<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;
use Cake\Http\Exception\BadRequestException;
use Cake\Utility\Hash;

/**
 * RequireAcceptHeader component
 */
class RequireAcceptHeaderComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'requires' => [],
    ];

    /**
     * Check if the first item in `Accept` header is in the required list or not.
     * If not exist, Cake\Http\Exception\BadRequestException will be raised.
     *
     * @param Cake\Event\Event $event event
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $requires = $this->getConfig('requires');
        if (empty($requires) || in_array('*', $requires)) {
            return;
        }

        $request = $event->getSubject()->getRequest();
        $response = $event->getSubject()->getResponse();
        $accepts = current($request->parseAccept());
        $firstAccept = $accepts ? current($accepts) : null;

        if ($firstAccept !== null && in_array($firstAccept, $requires)) {
            return;
        }

        throw new BadRequestException(
            "Only allow one of following 'Accept' headers: " . implode(', ', $requires)
        );
    }
}
