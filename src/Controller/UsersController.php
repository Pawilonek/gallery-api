<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $users = $this->Users->find('all');
        $this->set([
            'users' => $users,
            '_serialize' => ['users']
        ]);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id)
    {
        $user = $this->Users->get($id);
        $this->set([
            'user' => $user,
            '_serialize' => ['user']
        ]);
    }

    /**
     * This function get request data and add new user. If request is
     * valid response had status code 201 and body contains added user
     * and jwt token. If validation fail response code is set to 400
     * and body contains validation errors.
     *
     * @return void
     */
    public function add()
    {
        // create new user
        $user = $this->Users->newEntity($this->request->data);
        // validate data and data
        if ($this->Users->save($user)) {
            // set status code: 201 - Created
            $this->response->statusCode(201);
            // Set response body
            $this->set([
                'user' => $user,
                'token' => $this->getToken($user),
                '_serialize' => ['user', 'token']
            ]);
            return;
        }

        // set status code: 400 - Bad Request
        $this->response->statusCode(400);
        // get validation errors
        $errors = $user->errors();
        // set response body
        $this->set([
            'errors' => $errors,
            '_serialize' => ['errors']
        ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id);
        $user = $this->Users->patchEntity($user, $this->request->data);
        if ($this->Users->save($user)) {
            // set status code: 201 - Created
            $this->response->statusCode(201);
            // Set response body
            $this->set([
                'user' => $user,
                '_serialize' => ['user']
            ]);
            return;
        }

        // set status code: 400 - Bad Request
        $this->response->statusCode(400);
        // get validation errors
        $errors = $user->errors();
        // set response body
        $this->set([
            'errors' => $errors,
            '_serialize' => ['errors']
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $user = $this->Users->get($id);

        if ($this->Users->delete($user)) {
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

    /**
     *
     */
    public function login()
    {
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException();
        }

        $this->set([
            'token' => $this->getToken($user),
            '_serialize' => ['token']
        ]);
    }

    /**
     * This function generate jwt token
     *
     * @param $user
     * @return string
     */
    private function getToken($user)
    {
        $token = \JWT::encode(
            array(
                'id' => $user['id'],
                'exp' => time() + 604800
            ),
            Security::salt()
        );
        return "Bearer " . $token;
    }
}
