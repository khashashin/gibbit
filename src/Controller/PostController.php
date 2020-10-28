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
}
