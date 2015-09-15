<?php
use Migrations\AbstractMigration;

class Authentications extends AbstractMigration
{
    /**
     * Create table with users hash
     *
     * @return void
     */
    public function change()
    {
        $table = $this->table('authentications');
        $table->addColumn('user_id', 'integer')
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->addColumn('hash', 'string', ['limit' => 100])
            ->addIndex('hash', ['unique' => true])
            ->addColumn('expiry_date', 'datetime')
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
