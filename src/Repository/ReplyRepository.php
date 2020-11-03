<?php

namespace App\Repository;


use App\Repository\Repository;
use App\Database\ConnectionHandler;
use Exception;

/**
 * Das UserRepository ist zuständig für alle Zugriffe auf die Tabelle "reply".
 *
 * Die Ausführliche Dokumentation zu Repositories findest du in der Repository Klasse.
 */
class ReplyRepository extends Repository
{
    /**
     * Diese Variable wird von der Klasse Repository verwendet, um generische
     * Funktionen zur Verfügung zu stellen.
     */
    protected $tableName = 'reply';

    /**
     * Erstellt einen neue Antwort auf einen Kommentar mit den gegebenen Werten.
     *.
     *
     * @param $user_id Wert für die Spalte user_id
     * @param $text Wert für die Spalte text
     * @param $comment_id Wert für die Spalte comment_id
     * @param $post_id Wert um weiterzuleiten
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     */
    public function create($user_id, $text, $comment_id, $post_id)
    {
        $query = "INSERT INTO {$this->tableName} (user_id, text, comment_id, is_approved) VALUES (?, ?, ?, ?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $approved = 1;
        $statement->bind_param('isii', $user_id, $text, $comment_id, $approved);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
        // Weiterleiten auf neu Post
        header('Location: /post/details/?id=' . $post_id);
    }

    /**
     * Aendert eine Antwort auf einen Kommentar mit den gegebenen Werten.
     *.
     *
     * @param $user_id Wert für die Spalte user_id
     * @param $text Wert für die Spalte text
     * @param $id Wert für die Spalte id
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     */
    public function change($text, $id)
    {
        session_start();
        if(isset($_SESSION['isLoggedIn']))
        {
            if(isset($text)) {
                if(!empty($text)) {
                    // Verhindert XSS
                    htmlspecialchars($text);
                } else {
                    header('/reply/change?error=Du kannst keinen Leeren Kommentar posten'); // Mit Fehler returnen, dass Werte leer waren
                }
            } else {
                header('/reply/change?error=Bitte gib einen Text ein'); // Mit Fehler returnen, dass Werte fehlen
            }

            $query = "UPDATE $this->tableName SET text = $text WHERE id = $id";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('si', $text, $id);
        }
        else
        {
            echo "Permission denied";
        }
    }
    /**
     * Returnt alle Replies die zu einer Kommentar ID gehören aus dem Table "reply"
     *
     * @param $commentID Wert für die Spalte comment_id
     */
    public function getAllRepliesForCommentID($commentID)
    {
        $query = "SELECT * FROM {$this->tableName} WHERE comment_id = $commentID";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        $replies = array();
        while ($reply = $result->fetch_object()) {
            $replies[] = $reply;
        }

        return $replies;
    }
}
