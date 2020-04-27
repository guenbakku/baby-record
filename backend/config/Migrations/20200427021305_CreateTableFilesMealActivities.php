<?php
use Migrations\AbstractMigration;

class CreateTableFilesMealActivities extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('files_meal_activities', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('file_id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('meal_activity_id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('created', 'datetime', [
            'null' => false,
        ])
        ->addColumn('modified', 'datetime', [
            'null' => false,
        ])
        ->addIndex(['file_id'])
        ->addIndex(['meal_activity_id'])
        ->create();
    }
}
