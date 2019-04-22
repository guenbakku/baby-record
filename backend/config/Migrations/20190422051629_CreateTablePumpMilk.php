<?php
use Migrations\AbstractMigration;

class CreateTablePumpMilk extends AbstractMigration
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
        $table = $this->table('pump_milk', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('baby_id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('started', 'datetime', [
            'null' => false,
        ])
        ->addColumn('duration', 'integer', [
            'null' => false,
        ])
        ->addColumn('volume', 'integer', [
            'null' => false,
        ])
        ->addColumn('memo', 'string', [
            'limit' => 256,
            'null' => true,
        ])
        ->addColumn('created', 'datetime', [
            'null' => false,
        ])
        ->addColumn('modified', 'datetime', [
            'null' => false,
        ])
        ->addIndex(['baby_id'])
        ->create();
    }
}
