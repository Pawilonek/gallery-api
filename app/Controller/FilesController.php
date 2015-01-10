<?php
App::uses('AppController', 'Controller');
/**
 * Files Controller
 *
 * @property File $File
 * @property PaginatorComponent $Paginator
 */
class FilesController extends AppController {

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
		$this->File->recursive = 0;
		$this->set('files', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->File->exists($id)) {
			throw new NotFoundException(__('Invalid file'));
		}
		$options = array('conditions' => array('File.' . $this->File->primaryKey => $id));
		$this->set('file', $this->File->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->File->create();
			if ($this->File->save($this->request->data)) {
				$this->Session->setFlash(__('The file has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The file could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->File->exists($id)) {
			throw new NotFoundException(__('Invalid file'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->File->save($this->request->data)) {
				$this->Session->setFlash(__('The file has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The file could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('File.' . $this->File->primaryKey => $id));
			$this->request->data = $this->File->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->File->id = $id;
		if (!$this->File->exists()) {
			throw new NotFoundException(__('Invalid file'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->File->delete()) {
			$this->Session->setFlash(__('The file has been deleted.'));
		} else {
			$this->Session->setFlash(__('The file could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
