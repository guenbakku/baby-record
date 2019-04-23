<?php
use Migrations\AbstractMigration;

class CreateTableCustomActivities extends AbstractMigration
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
        $table = $this->table('custom_activities', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('activity_id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('title', 'string', [
            'limit' => 128,
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
