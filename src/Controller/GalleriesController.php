<?php
namespace App\Controller;

use Cake\Event\Event;
use App\Controller\AppController;

/**
 * Galleries Controller
 *
 * @property \App\Model\Table\GalleriesTable $Galleries
 */
class GalleriesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }

    public function index()
    {
        $galleries = $this->Galleries->find('all');
        $this->set([
            'galleries' => $galleries,
            '_serialize' => ['galleries']
        ]);
    }

    public function view($id = null)
    {
        $gallery = $this->Galleries->get($id, [
            'contain' => ['Layouts', 'Layouts.Images']
        ]);
        $this->set([
            'gallery' => $gallery,
            '_serialize' => ['gallery']
        ]);
    }

    public function add()
    {
        // create new user
        $gallery = $this->Galleries->newEntity($this->request->data);
        // validate data and data
        if ($this->Galleries->save($gallery)) {
            // set status code: 201 - Created
            $this->response->statusCode(201);
            // Set response body
            $this->set([
                'gallery' => $gallery,
                '_serialize' => ['gallery']
            ]);
            return;
        }

        // set status code: 400 - Bad Request
        $this->response->statusCode(400);
        // get validation errors
        $errors = $gallery->errors();
        // set response body
        $this->set([
            'errors' => $errors,
            '_serialize' => ['errors']
        ]);
    }

    public function edit($id = null)
    {
        $gallery = $this->Galleries->get($id);
        $gallery = $this->Galleries->patchEntity($gallery, $this->request->data);
        if ($this->Galleries->save($gallery)) {
            // set status code: 201 - Created
            $this->response->statusCode(201);
            // Set response body
            $this->set([
                'gallery' => $gallery,
                '_serialize' => ['gallery']
            ]);
            return;
        }

        // set status code: 400 - Bad Request
        $this->response->statusCode(400);
        // get validation errors
        $errors = $gallery->errors();
        // set response body
        $this->set([
            'errors' => $errors,
            '_serialize' => ['errors']
        ]);
    }

    public function delete($id = null)
    {
        $gallery = $this->Galleries->get($id);

        if ($this->Galleries->delete($gallery)) {
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
