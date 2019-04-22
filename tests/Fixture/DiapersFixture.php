<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DiapersFixture
 */
class DiapersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'baby_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'started' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'is_pee' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'is_shit' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'memo' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'baby_id' => ['type' => 'index', 'columns' => ['baby_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => '639f4d33-7d1f-4896-ae50-6ef0c96a7b1f',
                'baby_id' => '6f931c60-cd0c-41b3-8689-72ccf1816f5a',
                'started' => '2019-04-22 05:28:26',
                'is_pee' => 1,
                'is_shit' => 1,
                'memo' => 'Lorem ipsum dolor sit amet',
                'created' => '2019-04-22 05:28:26',
                'modified' => '2019-04-22 05:28:26'
            ],
        ];
        parent::init();
    }
}
