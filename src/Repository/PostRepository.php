<?php


namespace App\Repository;

use App\Database\ConnectionHandler;
use Exception;

/**
 * Das PostRepository ist zuständig für alle Zugriffe auf die Tabelle "post".
 *
 * Die Ausführliche Dokumentation zu Repositories findest du in der Repository Klasse.
 */
class PostRepository extends Repository
{
    protected $tableName = 'post';

    /**
     * Erstellt einen neuen Post mit den gegebenen Werten.
     *
     * @param string $title Wert für die Spalte title
     * @param string $text Wert für die Spalte text
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     *
     */
    public function create(string $title, string $text) {
        $query = "INSERT INTO $this->tableName (user_id, title, text, is_approved) VALUES (?, ?, ?, ?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('issi', $_SESSION['userid'], $title, $text, $is_approved = 1);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
        // Weiterleiten auf neu erstellten Post
        header('Location: /post/details/?id=' . $statement->insert_id);
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
    public function update($post_id, $title, $text) {
        $query = "UPDATE $this->tableName SET title = ?, text = ? WHERE id = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ssi', $title, $text, $post_id);
        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
        // Weiterleiten auf geupdateten Post -- NEEDS FIX
        header('Location: /post/details/?id=' . $statement->insert_id);
    }
}
