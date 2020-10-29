<?php


namespace App\Controller;


use App\Repository\PostRepository;
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
    }

    public function phpinfo() {
        $view = new View('post/phpinfo');
        $view->display();
    }

    /**
     * Index wird als Übersicht von alle Posts verwendet
     */
    public function index() {
        $view = new View('post/index');
        $view->title = 'Posts';
        $view->heading = 'Posts';
        $view->posts = $this->postRepository->readAll($max=10);
        $view->display();
    }

    /**
     * Details wird als Detail Seite für einzelne Posts verwendet
     */
    public function details() {
        $post = $this->postRepository->readById($_GET['id']);

        $view = new View('post/details');
        $view->title = $post->title;
        $view->heading = $post->title;
        $view->post = $post;
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
     * Versucht den Post in der Datenbank zu erstellen
     */
    public function doCreate() {
        if (isset($_POST)) {
            $title = $_POST['title'];
            $text = $_POST['text'];
            $this->postRepository->create($title, $text);
        }
    }
}
