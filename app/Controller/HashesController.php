<?php
App::uses('AppController', 'Controller');
/**
 * Hashes Controller
 *
 * @property Hash $Hash
 * @property PaginatorComponent $Paginator
 */
class HashesController extends AppController {

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
		$this->Hash->recursive = 0;
		$this->set('hashes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Hash->exists($id)) {
			throw new NotFoundException(__('Invalid hash'));
		}
		$options = array('conditions' => array('Hash.' . $this->Hash->primaryKey => $id));
		$this->set('hash', $this->Hash->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Hash->create();
			if ($this->Hash->save($this->request->data)) {
				$this->Session->setFlash(__('The hash has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The hash could not be saved. Please, try again.'));
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
		if (!$this->Hash->exists($id)) {
			throw new NotFoundException(__('Invalid hash'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Hash->save($this->request->data)) {
				$this->Session->setFlash(__('The hash has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The hash could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Hash.' . $this->Hash->primaryKey => $id));
			$this->request->data = $this->Hash->find('first', $options);
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
		$this->Hash->id = $id;
		if (!$this->Hash->exists()) {
			throw new NotFoundException(__('Invalid hash'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Hash->delete()) {
			$this->Session->setFlash(__('The hash has been deleted.'));
		} else {
			$this->Session->setFlash(__('The hash could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
