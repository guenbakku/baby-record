<?php
use Migrations\AbstractMigration;

class AddColumnSexIdToTableBabies extends AbstractMigration
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
        $table = $this->table('babies');
        $table->addColumn('sex_id', 'integer', [
            'after' => 'birthday',
            'default' => 2,
            'null' => false,
        ])
        ->update();
    }
}
