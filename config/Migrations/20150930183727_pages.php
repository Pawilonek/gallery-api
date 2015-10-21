<?php
use Migrations\AbstractMigration;

class Pages extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
        $table = $this->table('pages');
        $table->addColumn('title', 'string', ['limit' => 100])
            ->addColumn('slug', 'string', ['limit' => 100])
            ->addColumn('body', 'text')
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();

        // Dodanie strony domowej
        $PagesTable = \Cake\ORM\TableRegistry::get('Pages');
        $page = $PagesTable->newEntity();
        $page->id = 1;
        $page->title = 'Home';
        $page->slug = 'home';
        $page->body = '<p>Witaj!</p><p>Bla bla bla...</p>';
        $PagesTable->save($page);
    }

    public function down()
    {
        $this->dropTable('pages');
    }
}
