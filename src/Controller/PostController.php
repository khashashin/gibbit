<?php


namespace App\Controller;


use App\Repository\PostRepository;
use App\View\View;

class PostController
{
    public function index() {
        $postRepository = new PostRepository();

        $view = new View('post/index');
        $view->title = 'Posts';
        $view->heading = 'Posts';
        $view->posts = $postRepository->readAll();
        $view->display();
    }
}
