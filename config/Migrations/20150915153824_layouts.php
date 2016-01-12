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
            ->addColumn('position_x', 'integer')
            ->addColumn('position_y', 'integer')
            ->addColumn('size_h', 'integer')
            ->addColumn('size_w', 'integer')
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
