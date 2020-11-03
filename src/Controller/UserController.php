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
        $view->display();
    }

    public function profile()
    {
        session_start();
        if($_SESSION['isLoggedIn'] && $_SESSION['userid']) {
            $view = new View('user/profile');
            $view->title = 'Profil';
            $view->display();
        } else {
            header('Location: /user/index');
        }
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

            $username = htmlspecialchars($_POST['username']);
            $first_name = htmlspecialchars($_POST['fname']);
            $last_name = htmlspecialchars($_POST['lname']);
            $email = htmlspecialchars($_POST['email']);
            $password = ($_POST['password']);
            $passwordRepeat = $_POST['passwordRepeat'];

            if($password !== $passwordRepeat) {
                header('Location: /user/create?error=Passwörter stimmen nicht überein'); // Mit Fehler returnen falls die Passwörter nicht übereinstimmen
                exit();
            } else {
                $password = hash('sha256', $password);
            }

            $userRepository = new UserRepository();
            $userRepository->create($username, $first_name, $last_name, $email, $password);
            header('Location: /user/index');
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
     * Updates the username
     * @throws \Exception
     */
    public function updateUsername()
    {
        session_start();
        if($_SESSION['isLoggedIn'] && $_SESSION['userid']) {
            if (isset($_POST)) {
                if($_POST['userid'] == $_SESSION['userid']) {
                    if (!(isset($_POST['username']) && isset($_POST['userid']) && !empty($_POST['username']) && !empty($_POST['userid']))) {
                        header('Location: /user/profile');
                    }

                    $username = htmlspecialchars($_POST['username']);
                    $userRepository = new UserRepository();
                    $userRepository->updateUsername($username, $_POST['userid']);

                } else {
                    header('Location: /user/profile');
                    exit();
                }
            } else {
                // Anfrage an die URI /user/create weiterleiten (HTTP 302)
                header('Location: /user/profile');
                exit();
            }
        } else {
            header('Location: /user/index/?error=Du musst eingeloggt sein, um deinen Account löschen zu können!');
        }
    }

    public function resetPassword()
    {
        session_start();
        // Validierungen
        if(!($_SESSION['isLoggedIn'] && $_SESSION['userid'])) {
            header('Location: /user/index/?error=Du musst eingeloggt sein, um dein Passwort ändern zu können!');
            exit();
        }
        if (!isset($_POST)) {
            header('Location: /user/profile/?error=Ein unbekannter Fehler ist aufgetreten');
            exit();
        }
        if(!($_POST['userid'] == $_SESSION['userid'])) {
            header('Location: /user/profile/?error=Ein unbekannter Fehler ist aufgetreten. Bitte versuche, dich aus- und wieder einzuloggen.');
            exit();
        }
        if (!(isset($_POST['currentPW']) && isset($_POST['newPW']) && isset($_POST['repeatedPW']) && isset($_POST['userid']))) {
            header('Location: /user/profile?error=Bitte achte darauf, überall einen Wert abzugeben!');
            exit();
        }

        if(!(!empty($_POST['currentPW']) && !empty($_POST['newPW']) && !empty($_POST['repeatedPW']) && !empty($_POST['userid']))) {
            header('Location: /user/profile?error=Bitte achte darauf, keine leeren Angaben zu machen!');
            exit();
        }

        $current_pw = $_POST['currentPW'];
        $new_pw = $_POST['newPW'];
        $repeated_new_pw = $_POST['repeatedPW'];
        $userid = $_POST['userid'];

        // Überprüfen ob die Angaben stimmen
        if($new_pw !== $repeated_new_pw) {
            header('Location: /user/profile/?error=Die Passwörter stimmen nicht überein!');
            exit();
        }

        // Passwort aus Datenbank lesen
        $userRepository = new UserRepository();
        $curr_pw_from_db = $userRepository->readById($userid)->password;

        // Wenn das Passwort stimmt -> Methode ausführen, ansonsten mit Fehler weiterleiten.
        if (hash('sha256',$current_pw) == $curr_pw_from_db) {
            $new_pw = hash('sha256', $new_pw);
            $userRepository->resetPassword($userid, $new_pw);
        } else {
            header('Location: /user/profile/?error=Das aktuelle Passwort wurde falsch eingegeben');
            exit();
        }
    }

    public function deleteUser()
    {
        session_start();
        if($_SESSION['isLoggedIn'] && $_SESSION['userid']) {
            $userRepository = new UserRepository();
            $userRepository->deleteById($_SESSION['userid']);
            unset($_SESSION);
            session_destroy();
        } else {
            header('Location: /user/index/?error=Du musst eingeloggt sein, um deinen Account löschen zu können!');
        }
        header('Location: /');
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
        header('Location: /user/index/');
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
