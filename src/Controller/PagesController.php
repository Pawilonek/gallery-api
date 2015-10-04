<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 */
class PagesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }

    public function index()
    {
        $pages = $this->Pages->find('all');
        $this->set([
            'pages' => $pages,
            '_serialize' => ['pages']
        ]);
    }

    public function view($id = null)
    {
        $page = $this->Pages->get($id);
        $this->set([
            'page' => $page,
            '_serialize' => ['page']
        ]);
    }

    public function add()
    {
        $page = $this->Pages->newEntity($this->request->data);
        if ($this->Pages->save($page)) {
            $this->response->statusCode(201);
            $this->set([
                'page' => $page,
                '_serialize' => ['page']
            ]);
            return;
        }

        $this->response->statusCode(400);
        $errors = $page->errors();
        $this->set([
            'errors' => $errors,
            '_serialize' => ['errors']
        ]);
    }

    public function edit($id = null)
    {
        $page = $this->Pages->get($id);
        $page = $this->Pages->patchEntity($page, $this->request->data);
        if ($this->Pages->save($page)) {
            $this->response->statusCode(201);
            $this->set([
                'page' => $page,
                '_serialize' => ['page']
            ]);
            return;
        }

        $this->response->statusCode(400);
        $errors = $page->errors();
        $this->set([
            'errors' => $errors,
            '_serialize' => ['errors']
        ]);
    }

    public function delete($id = null)
    {
        $page = $this->Pages->get($id);

        if ($this->Pages->delete($page)) {
            $message = 'deleted';
        } else {
            $this->response->statusCode(500);
            $message = 'error';
        }

        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
}
