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

            if($this->is_valid_user($_POST['username'], $_POST['password'], $_POST['fname'], $_POST['lname'], $_POST['email'])) {
                exit();
            }

            htmlspecialchars($username = $_POST['username']);
            htmlspecialchars($first_name = $_POST['fname']);
            htmlspecialchars($last_name = $_POST['lname']);
            htmlspecialchars($email = $_POST['email']);
            $password = $_POST['password'];
            $passwordRepeat = $_POST['passwordRepeat'];

            if($password !== $passwordRepeat) {
                header('Location: /user/create?error=Passwörter stimmen nicht überein'); // Mit Fehler returnen falls die Passwörter nicht übereinstimmen
                exit();
            } else {
                $password = hash('sha256', $password);
            }

            $userRepository = new UserRepository();
            $userRepository->create($username, $first_name, $last_name, $email, $password);

        } else {
            // Anfrage an die URI /user/create weiterleiten (HTTP 302)
            header('Location: /user/create');
            exit();
        }
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

    function is_valid_user($username, $password, $first_name, $last_name, $email) {
        // Password validieren
        if(!isset($password)) {
            header('/user/create?error=Es muss ein Passwort angegeben werden'); // Mit Fehler returnen, dass das PW leer war
            return false;
        }

        // Eingabe validieren
        if(isset($username) && isset($first_name) && isset($last_name) && isset($email)) {
            if(!empty($username) && !empty($first_name) && !empty($last_name) && !isset($email)) {
                return true;
            } else {
                header('/user/create?error=Bitte lasse keine Eingabe leer'); // Mit Fehler returnen, dass Werte leer waren
                return false;
            }
        } else {
            header('/user/create?error=Bitte gib überall einen Wert an'); // Mit Fehler returnen, dass Werte fehlen
            return false;
        }
    }
}
