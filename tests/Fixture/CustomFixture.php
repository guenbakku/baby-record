<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CustomFixture
 */
class CustomFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'custom';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'baby_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'title' => ['type' => 'string', 'length' => 128, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
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
                'id' => '8f5bcd99-3af4-4f3e-9fc3-edf80ac868b8',
                'baby_id' => 'd47072e8-bbc9-47b2-bc2d-0d4da179d37c',
                'title' => 'Lorem ipsum dolor sit amet',
                'memo' => 'Lorem ipsum dolor sit amet',
                'created' => '2019-04-22 05:29:59',
                'modified' => '2019-04-22 05:29:59'
            ],
        ];
        parent::init();
    }
}
