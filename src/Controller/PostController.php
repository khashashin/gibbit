<?php


namespace App\Controller;


use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\View\View;

class PostController
{
    public function __construct() {
        $this->postRepository = new PostRepository();
    }

    public function index() {
        $view = new View('post/index');
        $view->title = 'Posts';
        $view->heading = 'Posts';
        $view->posts = $this->postRepository->readAll($max=10);
        $view->display();
    }

    public function details() {
        $post = $this->postRepository->readById($_GET['id']);

        $view = new View('post/details');
        $view->title = $post->title;
        $view->heading = $post->title;
        $view->post = $post;
        $view->display();
    }

    public function create() {
        session_start();
        if (!isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            $view = new View('post/create');
            $view->title = 'Post erstellen';
            $view->heading = 'Post erstellen';
            $view->display();
        } else {
            header('Location: /user/index?error=Du bist nicht eingeloggt!');
        }
    }

    public function doCreate() {
        if (isset($_POST)) {
            $title = $_POST['title'];
            $text = $_POST['text'];
            $this->postRepository->create($title, $text);
        }
    }
}
