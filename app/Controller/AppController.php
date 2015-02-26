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
class AppController extends Controller
{

    public $components = array('RequestHandler');
    protected $loggedUser = false;

    public function beforeFilter()
    {
        parent::beforeFilter();
        $supportedExtensions = array('json');
        // If there is not supported extension, treat request as json.
        if (empty($this->RequestHandler->ext) || !in_array($this->RequestHandler->ext, $supportedExtensions)) {
            $this->RequestHandler->ext = 'json';
        }

        // Autentykacja
        $this->loggedUser = $this->checkUserHash();
    }

    protected function checkUserHash()
    {
        $userHash = $this->request->header('userHash');
        
        // Sprawdzanie czy klient wysłał userHash
        if (!$userHash) {
            return false;
        }
        
        // Szukanie użytkownika po userHash
        $this->loadModel('Authentication');
        $loggedUser = $this->Authentication->find('first', array(
            'conditions' => array(
                'Authentication.hash' => $userHash
            )
        ));

        // Sprawdzanie, czy użytkownik został znaleziony
        if (empty($loggedUser)) {
            return false;
        }

        // Sprawdzanie, czy sesja wygasła
        App::uses('CakeTime', 'Utility');
        $expiryDate = CakeTime::fromString($loggedUser['Authentication']['expiry_date']);
        if ($expiryDate < time()) {
            throw new Exception("sessionExpired", 403);
        }
        
        // Odświerzenie daty wygaśnięcia 
        $newDate = CakeTime::fromString(Authentication::HASH_AVAILABILITY_TIME);
        $sqlDate = CakeTime::toServer($newDate);
        $loggedUser['Authentication']['expiry_date'] = $sqlDate;
        $this->Authentication->save($loggedUser['Authentication']);
        
        return $loggedUser['User'];
    }

    protected function showError($code, $message = "")
    {
        $this->response->statusCode($code);
        $this->set(array(
            'message' => $message,
            '_serialize' => array(
                'message')
        ));
    }

    protected function generateUrl($string)
    {
        $string = strtolower($string);
        $plCharset = array(
            ',',
            ' - ',
            ' ',
            'ę',
            'Ę',
            'ó',
            'Ó',
            'Ą',
            'ą',
            'Ś',
            'ś',
            'ł',
            'Ł',
            'ż',
            'Ż',
            'Ź',
            'ź',
            'ć',
            'Ć',
            'ń',
            'Ń',
            '-',
            "'",
            "/",
            "?",
            '"',
            ":",
            '!',
            '.',
            '&',
            '&amp;',
            '#',
            ';',
            '[',
            ']',
            '(',
            ')',
            '`',
            '%',
            '”',
            '„',
            '…');
        $international = array(
            '-',
            '-',
            '-',
            'e',
            'E',
            'o',
            'P',
            'A',
            'a',
            'S',
            's',
            'l',
            'L',
            'z',
            'Z',
            'z',
            'Z',
            'c',
            'C',
            'n',
            'N',
            '-',
            "",
            "",
            "",
            "",
            "",
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '');
        $string = str_replace($plCharset, $international, $string);

        $string = preg_replace('/[^0-9a-z\-]+/', '', $string);
        $string = preg_replace('/[\-]+/', '-', $string);
        $string = trim($string, '-');
        return $string;
    }

}
