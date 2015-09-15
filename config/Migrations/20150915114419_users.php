<?php
use Migrations\AbstractMigration;

class Users extends AbstractMigration
{
    /**
     * Create users table
     *
     * @return void
     */
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('username', 'string', ['limit' => 50])
            ->addColumn('password', 'string', ['limit' => 100])
            ->addColumn('email', 'string', ['limit' => 50])
            ->addColumn('role', 'string', ['limit' => 10])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
