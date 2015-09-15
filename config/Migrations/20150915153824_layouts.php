<?php
use Migrations\AbstractMigration;

class Layouts extends AbstractMigration
{
    /**
     * Create images table
     *
     * @return void
     */
    public function change()
    {
        $table = $this->table('layouts');
        $table->addColumn('image_id', 'integer')
            ->addForeignKey('image_id', 'images', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->addColumn('gallery_id', 'integer')
            ->addForeignKey('gallery_id', 'galleries', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
