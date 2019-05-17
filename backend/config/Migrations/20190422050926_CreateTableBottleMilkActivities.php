<?php
use Migrations\AbstractMigration;

class CreateTableBottleMilkActivities extends AbstractMigration
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
        $table = $this->table('bottle_milk_activities', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('activity_id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('duration', 'integer', [
            'null' => false,
        ])
        ->addColumn('breast_volume', 'integer', [
            'default' => 0,
            'null' => false,
        ])
        ->addColumn('fomular_volume', 'integer', [
            'default' => 0,
            'null' => false,
        ])
        ->addColumn('created', 'datetime', [
            'null' => false,
        ])
        ->addColumn('modified', 'datetime', [
            'null' => false,
        ])
        ->addIndex(['activity_id'])
        ->create();
    }
}
