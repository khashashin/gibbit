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
        session_start();
        // Überprüfen ob der Nutzer eingeloggt ist
        if(isset($_SESSION['isLoggedIn']) && !empty($_SESSION['userid'])) {

            // Eingabe validieren
            if (isset($title) && isset($text)) {
                if (!empty($title) && !empty($text)) {
                    // Verhindert XSS
                    htmlspecialchars($title);
                    htmlspecialchars($text);
                } else {
                    header('/post/create?error=Bitte lasse keine Eingabe leer'); // Mit Fehler returnen, dass Werte leer waren
                }
            } else {
                header('/post/create?error=Bitte gib überall einen Wert an'); // Mit Fehler returnen, dass Werte fehlen
            }

            $query = "INSERT INTO $this->tableName (user_id, title, text, is_approved) VALUES (?, ?, ?, ?)";
            $statement = ConnectionHandler::getConnection()->prepare($query);

            $statement->bind_param('issi', $_SESSION['userid'], $title, $text, $is_approved = 1);

            if (!$statement->execute()) {
                throw new Exception($statement->error);
            }

            // Weiterleiten auf neu erstellten Post
            header('Location: /post/details/?id=' . $statement->insert_id);

        } else {
            header('Location: /user/login/?error=Du musst eingeloggt sein, um Posts erstellen zu können!');
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

    /**
     * Schick alle Posts die vom bestimmte User erstellt wurde.
     *
     * @param int $user_id Wert für die Spalte title
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     *
     */
    public function getAllPostsByUser(int $user_id) {

        $query = "SELECT * FROM {$this->tableName} WHERE user_id=?";
        $statement = ConnectionHandler::getConnection()->prepare($query);

        $statement->bind_param('i', $user_id);

        // Das Statement absetzen
        $statement->execute();

        // Resultat der Abfrage holen
        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Datensätze aus dem Resultat holen und in das Array $rows speichern
        $rows = array();
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }

        return $rows;

    }

}
