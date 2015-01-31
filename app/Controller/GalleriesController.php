<?php

App::uses('AppController', 'Controller');

/**
 * Galleries Controller
 *
 * @property Gallery $Gallery
 * @property PaginatorComponent $Paginator
 */
class GalleriesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $galleries = $this->Gallery->find('all');
        $this->set(array(
            'galleries' => $galleries,
            '_serialize' => array('galleries')
        ));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Gallery->recursive = 2;
        $gallery = $this->Gallery->findById($id);
        $this->set(array(
            'gallery' => $gallery,
            '_serialize' => array('gallery')
        ));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $data = $this->request->input();
        $data = json_decode($data, true);
        $this->Gallery->create();
        
        $data['url'] = $this->generateUrl($data['name']);

        $gallery = $this->Gallery->save($data);
        if (!$gallery) {
            $validationErrors = $this->Gallery->validationErrors;
            $this->response->statusCode(400);
        } else {
            $validationErrors = array();
        }

        $this->set(array(
            'gallery' => $gallery,
            'validationErrors' => $validationErrors,
            '_serialize' => array('gallery', 'validationErrors')
        ));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        
        if (!$this->Gallery->findById($id)) {
            $this->showError(404, "Not found");
            return false;
        }

        $this->Gallery->id = $id;
        $data = $this->request->input();
        $data = json_decode($data, true);

        // We use id from url not from request body
        if(array_key_exists('id', $data)){
            unset($data['id']);
        }

        $gallery = $this->Gallery->save($data);
        if (!$gallery) {
            $validationErrors = $this->Gallery->validationErrors;
            $this->response->statusCode(400);
        } else {
            $validationErrors = array();
        }

        $this->set(array(
            'gallery' => $gallery,
            'validationErrors' => $validationErrors,
            '_serialize' => array('gallery', 'validationErrors')
        ));

    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if ($this->Gallery->delete($id)) {
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
