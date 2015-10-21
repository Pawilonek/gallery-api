<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Layouts Controller
 *
 * @property \App\Model\Table\LayoutsTable $Layouts
 */
class LayoutsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        //$this->Auth->allow();
    }

    public function index()
    {
        $layouts = $this->Layouts->find('all');
        $this->set([
            'layouts' => $layouts,
            '_serialize' => ['layouts']
        ]);
    }

    public function view($id = null)
    {
        $layout = $this->Layouts->get($id);
        $this->set([
            'layout' => $layout,
            '_serialize' => ['layout']
        ]);
    }

    public function add()
    {
        // create new layout
        $layout = $this->Layouts->newEntity($this->request->data);
        // validate data and data
        if ($this->Layouts->save($layout)) {
            // set status code: 201 - Created
            $this->response->statusCode(201);
            // Set response body
            $this->set([
                'layout' => $layout,
                '_serialize' => ['layout']
            ]);
            return;
        }

        // set status code: 400 - Bad Request
        $this->response->statusCode(400);
        // get validation errors
        $errors = $layout->errors();
        // set response body
        $this->set([
            'errors' => $errors,
            '_serialize' => ['errors']
        ]);
    }

    public function edit($id = null)
    {
        $layout = $this->Layouts->get($id);
        $layout = $this->Layouts->patchEntity($layout, $this->request->data);
        if ($this->Layouts->save($layout)) {
            // set status code: 201 - Created
            $this->response->statusCode(201);
            // Set response body
            $this->set([
                'layout' => $layout,
                '_serialize' => ['layout']
            ]);
            return;
        }

        // set status code: 400 - Bad Request
        $this->response->statusCode(400);
        // get validation errors
        $errors = $layout->errors();
        // set response body
        $this->set([
            'errors' => $errors,
            '_serialize' => ['errors']
        ]);
    }

    public function delete($id = null)
    {
        $layout = $this->Layouts->get($id);

        if ($this->Layouts->delete($layout)) {
            $message = 'deleted';
        } else {
            // something wired heppend
            // set status code: 500 - Internal Server Error
            $this->response->statusCode(500);
            $message = 'error';
        }

        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
}
