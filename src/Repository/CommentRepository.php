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

            if(isset($text)) {
                if(!empty($text)) {
                    // Verhindert XSS
                    htmlspecialchars($text);
                } else {
                    header('/comment/create?error=Bitte lasse die Eingabe nicht leer'); // Mit Fehler returnen, dass Werte leer waren
                }
            } else {
                header('/comment/create?error=Bitte gib einen Text ein'); // Mit Fehler returnen, dass Werte fehlen
            }

            $query = "INSERT INTO $this->tableName ($user_id, $text, $post_id) VALUES (?, ?, ?)";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('isi', $user_id, $text, $post_id);

            if (!$statement->execute())
            {
                throw new Exception($statement->error);
            }

            return $statement->insert_id;



    }

    /**
     * Aendert einen Kommentar mit den gegebenen Werten.
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
        if(isset($_SESSION['isLoggedIn']))
        {
            if(isset($text)) {
                if(!empty($text)) {
                    // Verhindert XSS
                    htmlspecialchars($text);
                } else {
                    header('/comment/change?error=Du kannst keinen Leeren Kommentar posten'); // Mit Fehler returnen, dass Werte leer waren
                }
            } else {
                header('/comment/change?error=Bitte gib einen Text ein'); // Mit Fehler returnen, dass Werte fehlen
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