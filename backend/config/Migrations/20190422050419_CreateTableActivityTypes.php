<?php
use Migrations\AbstractMigration;

class CreateTableActivityTypes extends AbstractMigration
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
        $table = $this->table('activity_types', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'integer', [
            'null' => false,
        ])
        ->addColumn('code', 'string', [
            'limit' => 64,
            'null' => false,
        ])
        ->addColumn('label', 'string', [
            'limit' => 64,
            'null' => false,
        ])
        ->addColumn('sort_no', 'integer', [
            'null' => false,
        ])
        ->addColumn('created', 'datetime', [
            'null' => false,
        ])
        ->addColumn('modified', 'datetime', [
            'null' => false,
        ])
        ->addIndex(['code'])
        ->create();
    }
}
