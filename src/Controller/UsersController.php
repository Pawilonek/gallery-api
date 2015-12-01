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

    /**
     *
     *
     * @param Event $event
     */
    public function beforeFilter(Event $event)
    {
        // wywoałnie funkcji rodzica
        parent::beforeFilter($event);
        // zezwolnie niezalogowanym użytkownikom na dostęp
        // do metody odpowiedzialnej za logowanie
        $this->Auth->allow(['login']);
    }

    /**
     * Metoda odpowiedzialna za wyświetlenie danych wszystkich użytkowników.
     *
     * @return void
     */
    public function index()
    {
        // pobranie wszystkich użytkowników
        $users = $this->Users->find('all');
        // przygotowanie odpowiedzi
        $this->set([
            'users' => $users,
            '_serialize' => ['users']
        ]);
    }

    /**
     * Metoda odpowiedzialna za wyświetlenie danych konkretnego użytkownika.
     *
     * @param string|null $id
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function view($id)
    {
        // pobranie informacji na temat użytkownika o podanym id
        $user = $this->Users->get($id);
        // przygotowanie odpowiedzi
        $this->set([
            'user' => $user,
            '_serialize' => ['user']
        ]);
    }

    /**
     * Funkcja ta odpowiedzialna jest za dodanie nowego użytkownika na podstawie
     * przesłanych danyhc. Jeżeli zapytanie jest prawidłowe i użytkownik zostanie
     * utworzony zostanie zwrócony token (JTW).
     *
     * @return void
     */
    public function add()
    {
        // stworzenie nowego użytkownika za podstawie przesłanych danych.
        $user = $this->Users->newEntity($this->request->data);
        // walidacja podanych danych i zapisanie urzytkownika
        if ($this->Users->save($user)) {
            // jeżeli użytkownik został zapisany
            // ustawienie kodu odpowiedzi: 201 - Created
            $this->response->statusCode(201);
            // przygotowanie odpowiedzi
            $this->set([
                'user' => $user,
                'token' => $this->getToken($user),
                '_serialize' => ['user', 'token']
            ]);

            return;
        }

        // ustawienie kodu odpowiedzi: 400 - Bad Request
        $this->response->statusCode(400);
        // pobranie błędów związanych z walidacją
        $errors = $user->errors();
        // przygotowanie odpowiedzi
        $this->set([
            'errors' => $errors,
            '_serialize' => ['errors']
        ]);
    }

    /**
     * Metoda odpowiedzialna za aktualizację danych użytkownika
     *
     * @param string|null $id
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function edit($id = null)
    {
        // pobranie użytkownika z bazy danych
        $user = $this->Users->get($id);
        // aktualizacja użytkownika na podstawie przesłanych danych
        $user = $this->Users->patchEntity($user, $this->request->data);
        // walidacja i zapisanie użytkownika
        if ($this->Users->save($user)) {
            // nowe dane są poprawne, użytkownik zaktualizowany
            // ustawienie kodu odpowiedzi: 200 - OK
            $this->response->statusCode(200);
            // przygotowanie odpowiedzi
            $this->set([
                'user' => $user,
                '_serialize' => ['user']
            ]);

            return;
        }

        // niepoprawne dane, ustawienie kodu odpowiedzi na: 400 - Bad Request
        $this->response->statusCode(400);
        // pobranie błędów walidacji
        $errors = $user->errors();
        // przygotowanie odpowiedzi
        $this->set([
            'errors' => $errors,
            '_serialize' => ['errors']
        ]);
    }

    /**
     * Metoda odpowiedzialna za usunięcie użytkownika
     *
     * @param string|null
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function delete($id = null)
    {
        // pobranie użytkownika o podanym id
        $user = $this->Users->get($id);

        // usunięcie użytkoniwka
        if ($this->Users->delete($user)) {
            // usuwanie się powiodło
            $message = 'deleted';
        } else {
            // z jakiegoś powodu nie można usunąć użytkownika
            // ustawienie kodu odpowiedzi: 500 - Internal Server Error
            $this->response->statusCode(500);
            $message = 'error';
        }

        // przygotowanie odpowiedzi
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }

    /**
     * Metoda odpowiedzialna za sprawdzenie poprawności przesłanych
     * danych (login i hasło) i wygenerowanie tokena
     *
     * @throw \Cake\Network\Exception\UnauthorizedException
     */
    public function login()
    {
        // sprawdzanie loginu i hasła użytkownika
        $user = $this->Auth->identify();
        if (!$user) {
            // niepoprawne dane
            throw new UnauthorizedException;
        }

        // wygenerowanie tokena i przygotowanie odpowiedzi
        $this->set([
            'token' => $this->getToken($user),
            '_serialize' => ['token']
        ]);
    }

    /**
     * Funkcja odpowiedzialna za wygenerowanie tokena (JWT)
     *
     * @param $user
     * @return string
     */
    private function getToken($user)
    {
        // Przygotowanie tokena
        $token = \JWT::encode(
            array(
                'id' => $user['id'],
                'role' => $user['role'],
                'exp' => time() + WEEK
            ),
            // dodanie soli na podstawie tej podanej w ustawieniach
            Security::salt()
        );

        // Dodanie przedrostka 'Bearer' wymaganego przy późniejszych zapytaniach
        return "Bearer " . $token;
    }
}
