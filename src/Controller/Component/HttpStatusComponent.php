<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;
use Cake\Utility\Hash;

/**
 * HttpStatus component
 */
class HttpStatusComponent extends Component
{

    protected static $httpStatus = [
        'ok' => 200,
        'created' => 201,
        'accepted' => 202,
        'no_content' => 204,
        'moved_permanently' => 301,
        'found' => 302,
        'see_other' => 303,
        'not_modified' => 304,
        'temporary_redirect' => 307,
        'bad_request' => 400,
        'unauthorized' => 401,
        'forbidden' => 403,
        'not_found' => 404,
        'method_not_allowed' => 405,
        'not_acceptable' => 406,
        'precondition_failed' => 412,
        'unsupported_media_type' => 415,
        'unprocessable_entity' => 422,
        'internal_server_error' => 500,
        'not_implemented' => 501,
    ];

    public $controller = null;

    /**
     * {@inheritDoc}
     */
    public function startup(Event $event)
    {
        $this->controller = $event->getSubject();
    }

    /**
     * Proxy to access to key in static::$httpStatus
     *
     * @param string $name method's name
     * @return int
     */
    public function __get($name)
    {
        return Hash::get(static::$httpStatus, $name);
    }

    /**
     * Set Http status code to response object
     *
     * @param string $name http status name
     * @return void
     */
    public function set($name)
    {
        $this->controller->response = $this->controller->response->withStatus(
            $this->{$name}
        );
    }
}
