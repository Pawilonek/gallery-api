<?php
App::uses('AppController', 'Controller');

/**
 * Layouts Controller
 *
 * @property Layout $Layout
 * @property PaginatorComponent $Paginator
 */
class LayoutsController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('RequestHandler');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $layouts = $this->Layout->find('all');
        $this->set(array(
            'layouts' => $layouts,
            '_serialize' => array('layouts')
        ));
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        $layout = $this->Layout->findById($id);
        $this->set(array(
            'layout' => $layout,
            '_serialize' => array('layout')
        ));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $data = $this->request->input();
        $data = json_decode($data, true);
        $this->Layout->create();

        $layout = $this->Layout->save($data);
        if (!$layout) {
            $validationErrors = $this->Layout->validationErrors;
            $this->response->statusCode(400);
        } else {
            $validationErrors = array();
        }

        $this->set(array(
            'layout' => $layout,
            'validationErrors' => $validationErrors,
            '_serialize' => array('layout', 'validationErrors')
        ));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        if (!$this->Layout->findById($id)) {
            $this->showError(404, "Not found");
            return false;
        }

        $this->Layout->id = $id;
        $data = $this->request->input();
        $data = json_decode($data, true);

        // We use id from url not from request body
        if(array_key_exists('id', $data)){
            unset($data['id']);
        }

        $layout = $this->Layout->save($data);
        if (!$layout) {
            $validationErrors = $this->Layout->validationErrors;
            $this->response->statusCode(400);
        } else {
            $validationErrors = array();
        }

        $this->set(array(
            'layout' => $layout,
            'validationErrors' => $validationErrors,
            '_serialize' => array('layout', 'validationErrors')
        ));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        if ($this->Layout->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}
