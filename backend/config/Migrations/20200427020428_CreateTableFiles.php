<?php
use Migrations\AbstractMigration;

class CreateTableFiles extends AbstractMigration
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
        $table = $this->table('files', ['id' => false, 'primary_key' => 'id']);
        $table->addColumn('id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('user_id', 'uuid', [
            'null' => false,
        ])
        ->addColumn('path', 'string', [
            'limit' => 512,
            'null' => false,
        ])
        ->addColumn('mime_type', 'string', [
            'limit' => 64,
            'null' => false,
        ])
        ->addColumn('size', 'integer', [
            'null' => false,
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
