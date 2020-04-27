<?php
use Migrations\AbstractMigration;

class CreateTableDishes extends AbstractMigration
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
        $table = $this->table('dishes', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('user_id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('name', 'string', [
            'limit' => 64,
            'null' => false,
        ])
        ->addColumn('memo', 'string', [
            'limit' => 512,
            'null' => true,
        ])
        ->addColumn('created', 'datetime', [
            'null' => false,
        ])
        ->addColumn('modified', 'datetime', [
            'null' => false,
        ])
        ->addIndex(['user_id'])
        ->create();
    }
}
