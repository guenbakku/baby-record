<?php
use Migrations\AbstractSeed;

/**
 * MealStatuses seed.
 */
class MealStatusesSeed extends AbstractSeed
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
                'code' => 'good',
                'label' => 'Good',
                'sort_no' => 1,
                'created' => $now,
                'modified' => $now
            ],
            [
                'id' => 2,
                'code' => 'normal',
                'label' => 'Normal',
                'sort_no' => 2,
                'created' => $now,
                'modified' => $now
            ],
            [
                'id' => 3,
                'code' => 'bad',
                'label' => 'Bad',
                'sort_no' => 3,
                'created' => $now,
                'modified' => $now
            ],
        ];

        $table = $this->table('meal_statuses');
        $table->insert($data)->save();
    }
}
