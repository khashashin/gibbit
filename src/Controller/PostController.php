<?php


namespace App\Controller;


use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\View\View;

/**
 * Siehe Dokumentation im DefaultController.
 */
class PostController
{
    /**
     * Initialisiere die notwendige Werte
     */
    public function __construct() {
        $this->postRepository = new PostRepository();
        $this->userRepository = new UserRepository();
    }

    /**
     * Index wird als Übersicht von alle Posts verwendet
     */
    public function index() {
        $view = new View('post/index');
        $view->title = 'Posts';
        $view->heading = 'Posts';
        $view->posts = $this->postRepository->readAll($max=10);
        $view->latest_posts_mobile = $this->postRepository->readAll($max=3);
        $view->display();
    }

    /**
     * Details wird als Detail Seite für einzelne Posts verwendet
     */
    public function details() {
        session_start();
        $post = $this->postRepository->readById($_GET['id']);
        $similar_posts = array();
        for ($i = 0; $i <= 3; $i++) {
            $randomizer = rand(1, 99);
            $similar_posts[] = $this->postRepository->readById($randomizer);
        }
        $user = $this->userRepository->readById($post->user_id);

        // Prüfe ob den Benutzer der Postinhaber ist.
        $is_post_owner = false;
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            if ($_SESSION['userid'] == $post->user_id) {
                $is_post_owner = true;
            }
        }
        $view = new View('post/details');
        $view->title = $post->title;
        $view->heading = $post->title;
        $view->post = $post;
        $view->user = $user;
        $view->similar_posts = $similar_posts;
        $view->is_post_owner = $is_post_owner;
        $view->display();
    }

    /**
     * User Posts wird als ein Übersicht auf alle Posts von bestimmte Benutzer verwendet
     */
    public function user_posts() {
        $posts = $this->postRepository->getAllPostsByUser($_GET['user_id']);
        $view = new View('post/user_posts');
        $view->title = 'Benutzer Posts';
        $view->heading = 'Benutzer Posts';
        $view->posts = $posts;
        $view->display();
    }

    /**
     * Create wird als Post erstellungsseite verwendet
     */
    public function create() {
        session_start();
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            $view = new View('post/create');
            $view->title = 'Post erstellen';
            $view->heading = 'Post erstellen';
            $view->display();
        } else {
            header('Location: /user/index?error=Du bist nicht eingeloggt!');
        }
    }

    /**
     * Edit wird als Post-Änderungsseite verwendet
     */
    public function edit() {
        session_start();
        $post = $this->postRepository->readById($_GET['id']);
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            $view = new View('post/edit');
            $view->title = 'Post editieren';
            $view->heading = 'Post editieren';
            $view->post = $post;
            $view->display();
        } else {
            header('Location: /user/index?error=Du bist nicht eingeloggt!');
        }
    }

    /**
     * Delete wird zum Post-löschen verwendet
     */
    public function delete() {
        session_start();
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            $this->postRepository->deleteById($_GET['id']);
            $view = new View('post/delete');
            $view->title = 'Post löschen';
            $view->heading = 'Post löschen';
            $view->display();
        } else {
            header('Location: /user/index?error=Du bist nicht eingeloggt!');
        }
    }

    /**
     * Versucht den Post in der Datenbank zu erstellen
     */
    public function doCreate() {
        if (isset($_POST)) {
            if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
                $title = $_POST['title'];
                $text = $_POST['text'];
                $this->postRepository->create($title, $text);
            }
        } else {
            // Anfrage an die URI /post/create weiterleiten (HTTP 302)
            header('Location: /post/create?error=Etwas ist schief gelaufen, wenden Sie sich bitte an die Administration.');
            exit();
        }
    }

    /**
     * Versucht den Post in der Datenbank zu aktualisieren
     */
    public function doUpdate() {
        if (isset($_POST)) {
            if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
                $title = $_POST['title'];
                $text = $_POST['text'];
                $post_id = $_POST['post_id'];
                $this->postRepository->update($post_id, $title, $text);
            }
        } else {
            // Anfrage an die URI /post/create weiterleiten (HTTP 302)
            header('Location: /post/create?error=Etwas ist schief gelaufen, wenden Sie sich bitte an die Administration.');
            exit();
        }
    }
}
