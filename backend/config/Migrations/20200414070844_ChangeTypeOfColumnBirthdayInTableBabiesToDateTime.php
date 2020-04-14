<?php
use Migrations\AbstractMigration;

class ChangeTypeOfColumnBirthdayInTableBabiesToDateTime extends AbstractMigration
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
        $table->changeColumn('birthday', 'datetime');
        $table->update();
    }
}
