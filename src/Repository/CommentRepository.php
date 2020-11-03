<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Database\ConnectionHandler;
use Exception;

/**
 * Das UserRepository ist zuständig für alle Zugriffe auf die Tabelle "comment".
 *
 * Die Ausführliche Dokumentation zu Repositories findest du in der Repository Klasse.
 */
class CommentRepository extends Repository
{
    /**
     * Diese Variable wird von der Klasse Repository verwendet, um generische
     * Funktionen zur Verfügung zu stellen.
     */
    protected $tableName = 'comment';

    /**
     * Erstellt einen neuen Kommentar mit den gegebenen Werten.
     *.
     *
     * @param $user_id Wert für die Spalte user_id
     * @param $text Wert für die Spalte text
     * @param $post_id Wert für die Spalte post_id
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     */
    public function create($user_id, $text, $post_id)
    {
            $query = "INSERT INTO {$this->tableName} (user_id, text, post_id) VALUES (?, ?, ?)";
            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('isi', $user_id, $text, $post_id);

            if (!$statement->execute())
            {
                throw new Exception($statement->error);
            }

            // Weiterleiten auf Post details Seite mit Kommentar
            header('Location: /post/details/?id=' . $post_id);

    }

    /**
     * Loescht einen Kommentar mit den gegebenen Werten.
     *.
     *
     * @param $user_id Wert für die Spalte user_id
     * @param $id Wert für die Spalte id
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     */
    public function delete($user_id, $id )
    {
        if(isset($_SESSION['isLoggedIn']))
        {
            $query = "";
        }
        else
        {
            echo "Permission denied";
        }
    }

    /**
     * Aktualisiert einen Post mit den gegebenen Werten.
     *
     * @param int $post_id Wert für die Spalte title
     * @param string $title Wert für die Spalte title
     * @param string $text Wert für die Spalte text
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     *
     */
    public function update($post_id, $comment_id, $text) {
        $query = "UPDATE $this->tableName SET text = ? WHERE id = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('si',  $text, $comment_id);
        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
        // Weiterleiten auf geupdateten Post -- NEEDS FIX
        header('Location: /post/details/?id=' . $post_id);

    }


    /**
     * Returnt alle Kommentare die zu einer Post ID gehören aus dem Table "reply"
     *
     * @param $postID Wert für die Spalte post_id
     */
    public function getAllCommentsForPostID($postID)
    {
        $query = "SELECT * FROM {$this->tableName} WHERE post_id = $postID";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        $comments = array();
        while ($comment = $result->fetch_object()) {
            $comments[] = $comment;
        }

        return $comments;
    }

}