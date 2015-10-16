<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\usersController Test Case
 */
class usersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users'
    ];

    /**
     * Ten test sprawdza poprawność danych po zapytaniu o konkretnrgo użytkownika.
     */
    public function testCorrectGet()
    {
        $token = \JWT::encode(
            array(
                'id' => 1,
                'exp' => time() + WEEK
            ),
            \Cake\Utility\Security::salt()
        );
        $token = "Bearer " . $token;

        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $token
            ]
        ]);

        // Pobieranie danych o użytkowniku o id 2
        $this->get('/users/2.json');

        // Sprawdzanie kodu odpowiedzi - 200 Ok
        $this->assertResponseOk();
        // sprawdzanie poprawności odpowiedzi
        $expected = [
            'user' => [
                'id' => 2,
                'username' => 'user',
                // hasło nie jest przesyłane w odpowiedzi
                'email' => 'user@user.com',
                'role' => 'user',
                'created' => '2015-10-16T12:00:15+0000',
                'modified' => '2015-10-16T12:00:15+0000',
            ],
        ];
        $expected = json_encode($expected, JSON_PRETTY_PRINT);
        $this->assertTextEquals($expected, $this->_response->body());
    }

    /**
     * Sprawdzanie zapytania o nieistniejącego użytkownika.
     * Kod odpowiedzi powinien być ustawiony na 404.
     */
    public function testIncorrectGet()
    {
        $this->configRequest([
            'headers' => ['Accept' => 'application/json']
        ]);

        // Pobieranie danych o użytkowniku o id 123
        $this->get('/users/123.json');

        // Sprawdzanie kodu odpowiedzi - 404 Not Found
        $this->assertResponseCode(404);
    }

    /**
     * Ten test sprawdza logowanie z poprawnymi danymi.
     * Jako odpowiedź powinien zostać zwrócony JWT.
     */
    public function testCorrectLogin()
    {
        $this->configRequest([
            'headers' => ['Accept' => 'application/json']
        ]);

        // logowanie z poprawnym hasłem
        $this->post('/users/login.json', [
            'username' => 'admin',
            'password' => 'admin'
        ]);

        // Sprawdzanie kodu odpowiedzi - 200 Ok
        $this->assertResponseOk();
        // sprawdzanie czy odpowiedź zawiera token
        $this->assertTextContains("token", $this->_response->body());
        // sprawdzanie czy token zawiera niezmienny początek, dalsza część tokenu jest generowana na podstawie czasu
        $this->assertTextContains("Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.", $this->_response->body());
    }

    /**
     * Ten test sprawdza logowanie z błędnymi danymi.
     * Kod odpowiedzi powinien być ustawiony na 401.
     */
    public function testIncorrectLogin()
    {
        $this->configRequest([
            'headers' => ['Accept' => 'application/json']
        ]);

        // logowanie z błędnym hasłem
        $this->post('/users/login.json', [
            'username' => 'admin',
            'password' => 'invalidPassword'
        ]);

        // Sprawdzanie kodu odpowiedzi - 401 (Unauthorized)
        $this->assertResponseCode(401);
    }
}
