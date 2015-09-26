<?php
namespace App\Controller;

use Cake\Event\Event;
use App\Controller\AppController;

/**
 * Images Controller
 *
 * @property \App\Model\Table\ImagesTable $Images
 */
class ImagesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }

    public function index()
    {
        $images = $this->Images->find('all');
        $this->set([
            'images' => $images,
            '_serialize' => ['images']
        ]);
    }

    public function view($id = null)
    {
        $image = $this->Images->get($id);
        $this->set([
            'image' => $image,
            '_serialize' => ['image']
        ]);
    }

    public function add()
    {
        // create new user
        $image = $this->Images->newEntity($this->request->data);
        // validate data and data
        if ($this->Images->save($image)) {
            // set status code: 201 - Created
            $this->response->statusCode(201);
            // Set response body
            $this->set([
                'image' => $image,
                '_serialize' => ['image']
            ]);
            return;
        }

        // set status code: 400 - Bad Request
        $this->response->statusCode(400);
        // get validation errors
        $errors = $image->errors();
        // set response body
        $this->set([
            'errors' => $errors,
            '_serialize' => ['errors']
        ]);

    }


    public function edit($id = null)
    {
        $image = $this->Images->get($id);
        $image = $this->Images->patchEntity($image, $this->request->data);
        if ($this->Images->save($image)) {
            // set status code: 201 - Created
            $this->response->statusCode(201);
            // Set response body
            $this->set([
                'image' => $image,
                '_serialize' => ['image']
            ]);
            return;
        }

        // set status code: 400 - Bad Request
        $this->response->statusCode(400);
        // get validation errors
        $errors = $image->errors();
        // set response body
        $this->set([
            'errors' => $errors,
            '_serialize' => ['errors']
        ]);
    }

    public function delete($id = null)
    {
        $image = $this->Images->get($id);

        if ($this->Images->delete($image)) {
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
