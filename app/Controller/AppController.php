<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('RequestHandler');
    protected $loggedUser = null;

    public function beforeFilter() {
        parent::beforeFilter();
        $supportedExtensions = array('json');
        // If there is not supported extension, treat request as json.
        if (empty($this->RequestHandler->ext) || !in_array($this->RequestHandler->ext, $supportedExtensions)) {
            $this->RequestHandler->ext = 'json';
        }

        // Autentykacja
        if (!empty($this->request->query['hash'])) {
            $hash = $this->request->query['hash'];
            //$this->loadModel('User');
            $this->loadModel('Authentication');
            $user = $this->Authentication->find('first', array(
                'conditions' => array(
                    'Authentication.hash' => $hash
                )
            ));

            // TODO: sprawdzanie czy sesja nie wygasła
            // $user['Authentication']['expiry_date'];

            $this->loggedUser = $user['User'];
        }
    }

    protected function showError($code, $message = "") {
        $this->response->statusCode($code);
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

    protected function generateUrl($string) {
        $string = strtolower($string);
        $plCharset = array(',', ' - ', ' ', 'ę', 'Ę', 'ó', 'Ó', 'Ą', 'ą', 'Ś', 'ś', 'ł', 'Ł', 'ż', 'Ż', 'Ź', 'ź', 'ć', 'Ć', 'ń', 'Ń', '-', "'", "/", "?", '"', ":", '!', '.', '&', '&amp;', '#', ';', '[', ']', '(', ')', '`', '%', '”', '„', '…');
        $international = array('-', '-', '-', 'e', 'E', 'o', 'P', 'A', 'a', 'S', 's', 'l', 'L', 'z', 'Z', 'z', 'Z', 'c', 'C', 'n', 'N', '-', "", "", "", "", "", '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
        $string = str_replace($plCharset, $international, $string);

        $string = preg_replace('/[^0-9a-z\-]+/', '', $string);
        $string = preg_replace('/[\-]+/', '-', $string);
        $string = trim($string, '-');
        return $string;
    }

}
