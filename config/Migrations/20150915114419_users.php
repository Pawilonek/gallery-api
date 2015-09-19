<?php
use Migrations\AbstractMigration;

class Users extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('users');
        $table->addColumn('username', 'string', ['limit' => 50])
            ->addIndex('username', array('unique' => true))
            ->addColumn('password', 'string', ['limit' => 100])
            ->addColumn('email', 'string', ['limit' => 50])
            ->addIndex('email', array('unique' => true))
            ->addColumn('role', 'string', ['limit' => 10, 'default' => 'user', 'null' => true])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();

        // Create admin/admin user
        $UsersTable = \Cake\ORM\TableRegistry::get('Users');
        $user = $UsersTable->newEntity();
        $user->username = 'admin';
        $user->password = 'admin';
        $user->email = 'admin@admin.com';
        $user->role = 'admin';
        $UsersTable->save($user);
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
