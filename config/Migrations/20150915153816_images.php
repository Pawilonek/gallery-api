<?php
use Migrations\AbstractMigration;

class Images extends AbstractMigration
{
    /**
     * Create images table
     *
     * @return void
     */
    public function change()
    {
        $table = $this->table('images');
        $table->addColumn('filename', 'string', ['limit' => 100])
            ->addIndex('filename', ['unique' => true])
            ->addColumn('original_filename', 'string', ['limit' => 100])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
