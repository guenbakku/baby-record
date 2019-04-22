<?php
use Migrations\AbstractMigration;

class CreateTableDiapers extends AbstractMigration
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
        $table = $this->table('diapers', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('baby_id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('started', 'datetime', [
            'null' => false,
        ])
        ->addColumn('is_pee', 'boolean', [
            'default' => false,
            'null' => false,
        ])
        ->addColumn('is_shit', 'boolean', [
            'default' => false,
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
