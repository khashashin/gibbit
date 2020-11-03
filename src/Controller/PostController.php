<?php


namespace App\Controller;


use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\ReplyRepository;
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
    public function __construct()
    {
        $this->postRepository = new PostRepository();
        $this->userRepository = new UserRepository();
        $this->commentRepository = new CommentRepository();
        $this->replyRepository = new ReplyRepository();
    }

    /**
     * Index wird als Übersicht von alle Posts verwendet
     */
    public function index()
    {
        // Holen der aktuellen seite nummer
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        // Seitenanzahl berechnen
        $total_pages = count($this->postRepository->readAll()) / 5;
        if ($page > $total_pages) {
            $page = $total_pages;
        }

        // View rendern
        $view = new View('post/index');
        $view->title = 'Posts';
        $view->posts = $this->postRepository->getByOffset($page);
        $view->latest_posts_mobile = $this->postRepository->readAll($max = 3);
        $view->total_pages = $total_pages;
        $view->display();
    }

    /**
     * Details wird als Detail Seite für einzelne Posts verwendet
     */
    public function details()
    {
        session_start();
        $post = $this->postRepository->readById($_GET['id']);
        $similar_posts = $this->postRepository->getRandomPosts();
        $user = $this->userRepository->readById($post->user_id);
        $comments = $this->commentRepository->getAllCommentsForPostID($_GET['id']);


        // Prüfe ob den Benutzer der Postinhaber ist.
        $is_post_owner = false;
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            if ($_SESSION['userid'] == $post->user_id) {
                $is_post_owner = true;
            }
        }

        // View rendern
        $view = new View('post/details');
        // Seitentitel (oben in der Leiste) wird jeweils der Posttitel
        $view->title = $post->title;
        $view->post = $post;
        $view->user = $user;
        $view->similar_posts = $similar_posts;
        $view->is_post_owner = $is_post_owner;
        $view->comments = $comments;

        $view->display();
    }

    /**
     * User Posts wird als ein Übersicht auf alle Posts von bestimmte Benutzer verwendet
     */
    public function user_posts()
    {
        $posts = $this->postRepository->getAllPostsByUser(@$_GET['user_id']);
        $view = new View('post/user_posts');
        $view->title = 'Benutzer Posts';
        $view->posts = $posts;
        $view->display();
    }

    /**
     * Zeigt die View um einen neuen Post zu erstellen
     */
    public function create()
    {
        session_start();

        // Falls der Benutzer eingeloggt ist wird ihm die Create View angezeigt, ansonsten ein Fehler
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            $view = new View('post/create');
            $view->title = 'Post erstellen';
            $view->display();
        } else {
            header('Location: /user/index/?error=Du bist nicht eingeloggt!');
        }
    }

    /**
     * Zeigt die View um einen post zu editieren
     * Dazu wird die Methode readById vom DefaultController verwendet
     */
    public function edit()
    {
        session_start();

        // Falls der Benutzer eingeloggt ist wird ihm die Edit View angezeigt, ansonsten ein Fehler
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            $post = $this->postRepository->readById($_GET['id']);
            $view = new View('post/edit');
            $view->title = 'Post editieren';
            $view->post = $post;
            $view->display();
        } else {
            header('Location: /user/index/?error=Du bist nicht eingeloggt!');
        }
    }

    /**
     * Löscht einen Post via PostRepository und zeigt anschliessend eine Bestätigungsmeldung
     * Zum Löschen wird die Methode deleteById vom DefaultController verwendet
     */
    public function delete()
    {
        session_start();

        //Falls der Benutzer eingeloggt ist funktioniert es, ansonsten bekomment er einen Fehler
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            $post = $this->postRepository->readById($_GET['id']);
            if ($_SESSION['userid'] == $post->user_id) {
                $this->postRepository->deleteById($_GET['id']);
                $view = new View('post/delete');
                $view->title = 'Post gelöscht';
                $view->display();
            } else {
                header('Location: /user/index?error=Du hast keine berechtigungen diesen Post zu löschen!');
            }
        } else {
            header('Location: /user/index?error=Du bist nicht eingeloggt!');
        }
    }

    /**
     * Zeigt eine Bestätigung dass der Kommentar gelöscht wurde
     */
    public function delete_comment()
    {
        session_start();
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            $comment= $this->commentRepository->readById($_GET['id']);
            if ($_SESSION['userid'] === $comment->user_id) {
                $this->commentRepository->deleteById($_GET['id']);
                $view = new View('comment/delete');
                $view->title = 'Kommentar gelöscht';
                $view->display();
            } else {
                header('Location: /user/index?error=Du hast keine berechtigungen diesen Kommentar zu löschen!');
            }
        } else {
            header('Location: /user/index?error=Du bist nicht eingeloggt!');
        }
    }

    /**
     * Validiert die Benutzereingabe und ruft die Methode zum Erstellen im Model auf
     */
    public function doCreate()
    {
        session_start();

        //Falls der Benutzer eingeloggt ist funktioniert es, ansonsten bekomment er einen Fehler
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            if (isset($_POST)) {
                if (!$this->post_is_valid($_POST['title'], $_POST['text'])) {
                    header('Location: /post/create');
                    exit();
                }
                // Durch htmlspecialchars XSS verhindern
                $title = htmlspecialchars($_POST['title']);
                $text = htmlspecialchars($_POST['text']);
                $this->postRepository->create($title, $text);
            }
        } else {
            header('Location: /user/index/?error=Du bist nicht eingeloggt!');
        }
    }

    /**
     * Validiert die Benutzereingabe und ruft die Methode zum Aktualisieren im Model auf
     */
    public function doUpdate()
    {
        session_start();

        //Falls der Benutzer eingeloggt ist funktioniert es, ansonsten bekomment er einen Fehler
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            if (isset($_POST)) {
                if (!$this->update_is_valid($_POST['post_id'], $_POST['title'], $_POST['text'])) {
                    header('Location: /post/index');
                    exit();
                }
                // Durch htmlspecialchars XSS verhindern
                $title = htmlspecialchars($_POST['title']);
                $text = htmlspecialchars($_POST['text']);
                $post_id = $_POST['post_id'];
                $this->postRepository->update($post_id, $title, $text);
            }
        } else {
            header('Location: /user/index/?error=Du bist nicht eingeloggt!');
        }
    }

    /**
     * Validiert, ob ein Post weder ungesetzt noch leer ist.
     * true = Postargumente sind valid
     * false = Postargumente sind invalid
     * Methode die von der Kommentar erstell form als action gebraucht wird
     */
    public function doCreateComment()
    {
        if (isset($_POST)) {
            if (!$this->comment_is_valid($_POST['text'])) {
                header('Location: /post/details/?id=' . $_POST['post_id']);
                exit();
            }
            $text = htmlspecialchars($_POST['text']);
            $post_id = $_POST['post_id'];
            $this->commentRepository->create($_SESSION['userid'], $text, $post_id);
        }
    }


    /**
     * Zeigt die View um einen Kommentar zu editieren
     */
    public function editComment()
    {
        session_start();
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            $post = $this->postRepository->readById($_GET['post_id']);
            $comment = $this->commentRepository->readById($_GET['comment_id']);
            $view = new View('comment/edit');
            $view->comment = $comment;
            $view->title = 'Post editieren';
            $view->post = $post;
            $view->display();
        } else {
            header('Location: /user/index?error=Du bist nicht eingeloggt!');
        }
    }

    /**
     * Validiert die Benutzereingabe und ruft die Methode zum Aktualisieren im Model auf
     */
    public function doUpdateComment()
    {
        session_start();
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
            if (isset($_POST)) {
                if (!$this->comment_update_is_valid($_POST['comment_id'], $_POST['text'])) {
                    header('Location: /post/index');
                    exit();
                }
                $text = htmlspecialchars($_POST['text']);
                $comment_id = $_POST['comment_id'];
                $post_id = $_POST['post_id'];
                $this->commentRepository->update($post_id, $comment_id, $text);
            }
        } else {
            header('Location: /user/index?error=Du bist nicht eingeloggt!');
        }
    }

    /**
     * Validiert, ob ein Post weder ungesetzt noch leer ist
     * @param $title
     * @param $text
     * @return bool
     */
    public function post_is_valid($title, $text)
    {
        session_start();

        // Überprüfen ob der Nutzer eingeloggt ist
        if (!(isset($_SESSION['isLoggedIn']) && !empty($_SESSION['userid']))) {
            header('Location: /user/login/?error=Bitte logge dich ein, um einen Post erstellen zu können!'); // Mit Fehler returnen, dass Nutzer nicht eingeloggt war
            return false;
        }

        // Eingabe validieren (Werte sind gesetzt)
        if (!(isset($title) && isset($text))) {
            header('/post/create?error=Bitte gib überall einen Wert an'); // Mit Fehler returnen, dass Werte fehlen
            return false;
        }

        // Eingabe validieren (Werte sind nicht leer)
        if (!(!empty($title) && !empty($text))) {
            header('/post/create?error=Bitte lasse keine Eingabe leer'); // Mit Fehler returnen, dass Werte leer waren
            return false;
        }
        return true;
    }

    /**
     * Validiert ob ein Post weder ungesetzt noch leer ist und überprüft, ob der Nutzer tatsächlich der Autor des Posts ist
     * @param $post_id
     * @param $title
     * @param $text
     * @return bool
     * @throws \Exception
     */
    public function update_is_valid($post_id, $title, $text)
    {
        session_start();

        // Prüfung ob Post valid ist
        $this->post_is_valid($title, $text);

        // Prüfung ob Post von Nutzer erstellt wurde
        if (!($this->postRepository->readById($post_id)->user_id === $_SESSION['userid'])) {
            header('Location: /post/edit/?error=Du bist hierzu nicht berechtigt!');
            return false;
        }
        return true;
    }

    /**
     * Validiert, ob ein Kommentar weder ungesetzt noch leer ist
     * @param $text
     * @return bool
     */
    public function comment_is_valid($text)
    {
        session_start();

        // Überprüfen ob der Nutzer eingeloggt ist
        if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['userid'])) {

            // Eingabe validieren (Werte sind gesetzt)
            if (isset($text)) {

                // Eingabe validieren (Werte sind nicht leer)
                if (!empty($text)) {
                    return true;
                } else {
                    header('/post/details?error=Bitte lasse keine Eingabe leer'); // Mit Fehler returnen, dass Werte leer waren
                    return false;
                }

            } else {
                header('/post/details?error=Bitte gib überall einen Wert an'); // Mit Fehler returnen, dass Werte fehlen
                return false;
            }

        } else {
            header('Location: /user/login/?error=Bitte logge dich ein, um einen Post erstellen zu können!'); // Mit Fehler returnen, dass Nutzer nicht eingeloggt war
            return false;
        }
    }

    /**
     * Validiert ob ein Kommentar weder ungesetzt noch leer ist
     * @param $user_id
     * @param $text
     * @param $post_id
     */
    public function comment_update_is_valid($text, $comment_id)
    {
        session_start();

        // Prüfung ob Post valid ist
        if ($this->comment_is_valid($text)) {
            return true;
        }
        // Prüfung ob Post von Nutzer erstellt wurde
        if (!($this->commentRepository->readById($comment_id)->user_id === $_SESSION['userid'])) {
            header('Location: /post/edit/?error=Du bist hierzu nicht berechtigt!');
            return false;
        }


        return false;
    }
}
