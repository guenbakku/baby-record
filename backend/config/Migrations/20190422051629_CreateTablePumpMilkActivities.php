<?php
use Migrations\AbstractMigration;

class CreateTablePumpMilkActivities extends AbstractMigration
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
        $table = $this->table('pump_milk_activities', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('activity_id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('duration', 'integer', [
            'null' => false,
        ])
        ->addColumn('volume', 'integer', [
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
