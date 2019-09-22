<?php
use Migrations\AbstractSeed;

/**
 * Sex seed.
 */
class SexesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            [
                'id' => 1,
                'code' => 'boy',
                'label' => 'Boy',
                'sort_no' => 1,
                'created' => $now,
                'modified' => $now
            ],
            [
                'id' => 2,
                'code' => 'girl',
                'label' => 'Girl',
                'sort_no' => 2,
                'created' => $now,
                'modified' => $now
            ],
        ];

        $table = $this->table('sexes');
        $table->insert($data)->save();
    }
}
