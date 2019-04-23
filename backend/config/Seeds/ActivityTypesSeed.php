<?php
use Migrations\AbstractSeed;

/**
 * ActivityTypes seed.
 */
class ActivityTypesSeed extends AbstractSeed
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
                'code' => 'BottleMilk',
                'label' => 'Bottle Milk',
                'sort_no' => 1,
                'created' => $now,
                'modified' => $now
            ],
            [
                'id' => 2,
                'code' => 'BreastMilk',
                'label' => 'Breast Milk',
                'sort_no' => 2,
                'created' => $now,
                'modified' => $now
            ],
            [
                'id' => 3,
                'code' => 'PumpMilk',
                'label' => 'Pump Milk',
                'sort_no' => 3,
                'created' => $now,
                'modified' => $now
            ],
            [
                'id' => 4,
                'code' => 'Diaper',
                'label' => 'Diaper',
                'sort_no' => 4,
                'created' => $now,
                'modified' => $now
            ],
            [
                'id' => 5,
                'code' => 'Temperature',
                'label' => 'Temperature',
                'sort_no' => 5,
                'created' => $now,
                'modified' => $now
            ],
            [
                'id' => 6,
                'code' => 'Custom',
                'label' => 'Custom',
                'sort_no' => 6,
                'created' => $now,
                'modified' => $now
            ],
        ];

        $table = $this->table('activity_types');
        $table->insert($data)->save();
    }
}
