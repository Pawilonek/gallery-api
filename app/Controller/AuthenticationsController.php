<?php

App::uses('AppController', 'Controller');

/**
 * Authentications Controller
 *
 * @property Authentication $Authentication
 * @property PaginatorComponent $Paginator
 */
class AuthenticationsController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        /*
        $authentications = $this->Authentication->find('all');
        $this->set(array(
            'Authentications' => $authentications,
            '_serialize' => array('authentications')
        ));
         * 
         */
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        exit;
    }

    /**
     * login
     *
     * @return void
     */
    public function add() {
        $data = $this->request->input();
        $data = json_decode($data, true);

        $this->loadModel('User');
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.username' => $data['username'],
                'User.password' => sha1($data['password']),
            )
        ));

        if(empty($user)){
            $this->showError(400, "Niepoprawna nazwa użytkownika i/lub hasło");
            return false;
        }
        
        $hash = $this->Authentication->create();
        $hash['user_id'] = $user['User']['id'];
        $hash['hash'] = time().md5(rand());
        $date = new DateTime(Authentication::HASH_AVAILABILITY_TIME);
        $hash['expiry_date'] = $date->format(DateTime::W3C);
        
        $hash = $this->Authentication->save($hash);
        
        $this->set(array(
            'hash' => $hash,
            '_serialize' => array('hash')
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

    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {

    }

}
