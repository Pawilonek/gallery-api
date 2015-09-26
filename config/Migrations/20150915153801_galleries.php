<?php
use Migrations\AbstractMigration;

class Galleries extends AbstractMigration
{
    /**
     * Create table with galleries
     *
     * @return void
     */
    public function change()
    {
        $table = $this->table('galleries');
        $table->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('slug', 'string', ['limit' => 100])
            ->addIndex('slug', ['unique' => true])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
