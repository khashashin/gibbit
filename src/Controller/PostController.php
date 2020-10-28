<?php


namespace App\Controller;


use App\Repository\PostRepository;
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
        $view->posts = $this->postRepository->readAll();
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
        $view = new View('post/create');
        $view->title = 'Post erstellen';
        $view->heading = 'Post erstellen';
        $view->display();
    }

    public function doCreate() {
        if (isset($_POST)) {
            $title = $_POST['title'];
            $text = $_POST['text'];

            $this->postRepository->create($title, $text);
        }
    }
}
