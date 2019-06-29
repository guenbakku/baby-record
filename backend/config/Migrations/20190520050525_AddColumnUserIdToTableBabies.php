<?php
use Migrations\AbstractMigration;

class AddColumnUserIdToTableBabies extends AbstractMigration
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
        $table->addColumn('user_id', 'uuid', [
            'after' => 'id',
            'null' => false,
        ])
        ->update();

        // Add dummy data to make it be able to add NOT NULL to field 'user_id'
        $sql = 'SELECT id FROM babies';
        $rows = $this->fetchAll($sql);
        foreach ($rows as $row) {
            $sql = "UPDATE babies
                SET user_id='temp'
                WHERE id='{$row['id']}'
            ";
            $this->execute($sql);
        }

        // Alter NOT NULL to field 'user_id'
        $table = $this->table('babies');
        $table->changeColumn('user_id', 'uuid', [
            'after' => 'id',
            'null' => false,
        ])
        ->addIndex(['user_id'])
        ->update();
    }
}
