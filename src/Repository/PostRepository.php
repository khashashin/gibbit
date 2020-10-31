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
     * @param int $user_id Wert für die Spalte title
     * @param string $title Wert für die Spalte title
     * @param string $text Wert für die Spalte text
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     *
     * @return int Das id von neu kreierte Post
     */
    public function create(int $user_id, string $title, string $text) {
        // Eingabe validieren
        if(isset($user_id) && isset($title) && isset($text)) {
            if(!empty($user_id) && !empty($title) && !empty($text)) {
                // Verhindert XSS
                htmlspecialchars($user_id);
                htmlspecialchars($title);
                htmlspecialchars($text);
            } else {
                header('/post/create?error=Bitte lasse keine Eingabe leer'); // Mit Fehler returnen, dass Werte leer waren
            }
        } else {
            header('/post/create?error=Bitte gib überall einen Wert an'); // Mit Fehler returnen, dass Werte fehlen
        }

        $query = "INSERT INTO $this->tableName (user_id, title, text, created_at, is_approved) VALUES (?, ?, ?, ?, ?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);

        $statement->bind_param('isssi', $user_id,$title, $text, date("c"), 1);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
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
    public function update(int $post_id, string $title, string $text) {
        session_start();
        // Eingabe validieren
        if(isset($title) && isset($text)) {
            if(!empty($title) && !empty($text)) {
                // Verhindert XSS
                htmlspecialchars($title);
                htmlspecialchars($text);
            } else {
                header('/post/create?error=Bitte lasse keine Eingabe leer'); // Mit Fehler returnen, dass Werte leer waren
            }
        } else {
            header('/post/create?error=Bitte gib überall einen Wert an'); // Mit Fehler returnen, dass Werte fehlen
        }

        $query = "UPDATE $this->tableName SET title=$title, text=$text WHERE id=$post_id";
        $statement = ConnectionHandler::getConnection()->prepare($query);

        $statement->bind_param('ss', $title, $text);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
        // Weiterleiten auf neu erstellte Post
        header('Location: /post/details/?id='.$statement->insert_id);

    }

}
