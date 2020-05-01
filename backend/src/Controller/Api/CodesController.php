<?php
namespace App\Controller\Api;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use App\Controller\Api\AppController;

/**
 * Codes Controller
 *
 * Return data from code tables to be used in select list in frontend
 */
class CodesController extends AppController
{

    /**
     * Whitelist of table models which this controller can access to.
     */
    protected $whitelist = [
        'ActivityTypes',
        'Sexes',
        'MealStatuses'
    ];

    public function view($slug)
    {
        $model = $this->_uriToModelName($slug);
        if (!in_array($model, $this->whitelist, true)) {
            throw new NotFoundException(
                "Could not find any table in whitelist with provided slug: $slug"
            );
        }

        $empty = filter_var($this->request->getQuery('empty', false), \FILTER_VALIDATE_BOOLEAN);

        $table = TableRegistry::get($model);
        $result = $table->find()
            ->select([
                'value' => 'id',
                'code' => 'code',
                'text' => 'label',
            ])
            ->order(['sort_no' => 'asc'])
            ->toArray();

        if ($empty) {
            array_unshift($result, [
                'value' => null,
                'code' => null,
                'text' => __('Please select')
            ]);
        }

        $this->set([
            'success' => true,
            'data' => [
                'codes' => $result,
            ],
            '_serialize' => ['success', 'data'],
        ]);
    }

    protected function _uriToModelName($model)
    {
        $model = str_replace('-', '_', $model);
        $model = Inflector::camelize($model);
        return $model;
    }
}
