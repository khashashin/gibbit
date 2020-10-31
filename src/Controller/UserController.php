<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\View\View;

/**
 * Siehe Dokumentation im DefaultController.
 */
class UserController
{
    /**
     * Index wird als Login verwendet
     */
    public function index()
    {
        $view = new View('user/login');
        $view->title = 'Anmelden';
        $view->display();
    }

    /**
     * Create wird als Registrierung verwendet
     */
    public function create()
    {
        $view = new View('user/registration');
        $view->title = 'Benutzer erstellen';
        $view->heading = 'Benutzer erstellen';
        $view->display();
    }

    /**
     * Versucht den Benutzer in der Datenbank zu registrieren
     */
    public function doCreate()
    {
        if (isset($_POST)) {
            $username = $_POST['username'];
            $first_name = $_POST['fname'];
            $last_name = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordRepeat = $_POST['passwordRepeat'];

            //die(var_dump($password) . var_dump($passwordRepeat) . var_dump($password !== $passwordRepeat));

            if($password !== $passwordRepeat) {
                header('Location: /user/create?error=Passwörter stimmen nicht überein'); // Mit Fehler returnen falls die Passwörter nicht übereinstimmen
                exit();
            }

            $userRepository = new UserRepository();
            $userRepository->create($username, $first_name, $last_name, $email, $password);
        } else {
            // Anfrage an die URI /user/create weiterleiten (HTTP 302)
            header('Location: /user/create');
            exit();
        }

        // User zum login weiterleiten
        header('Location: /user/index');
    }

    /**
     * Versucht den Benutzer einzuloggen
     */
    public function doLogin()
    {
        session_start();
        $userRepository = new UserRepository();
        if ($userRepository->readByUsername($_POST['username'])) {
            $user = $userRepository->readByUsername($_POST['username']);
            $password = $user->password;
            if (hash('sha256',$_POST['password']) == $password) {
                $_SESSION['userid'] = $user->id; // Session Variable setzen (User ID)
                $_SESSION['username'] = $user->username; // Session Variable setzen (Username)
                $_SESSION['isLoggedIn'] = true; // Session Variable setzen (Boolean LoggedIn)
                header('Location: /');
            } else {
                header('Location: /user/index?error=Falsches Passwort'); // Weiterleitung zur Anmeldung mit Error
            }
        } else {
            header('Location: /user/index?error=Falscher Benutzername'); // Weiterleitung zur Anmeldung mit Error
        }
    }

    /**
     * Zerstört die session und das $_SESSION Array
     * Leitet auf die Homepage weiter
     */
    public function logout()
    {
        session_start();
        unset($_SESSION);
        session_destroy();
        header('Location: /');
    }
}
