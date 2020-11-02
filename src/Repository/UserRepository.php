<?php

namespace App\Repository;

use App\Database\ConnectionHandler;
use Exception;

/**
 * Das UserRepository ist zuständig für alle Zugriffe auf die Tabelle "user".
 *
 * Die Ausführliche Dokumentation zu Repositories findest du in der Repository Klasse.
 */
class UserRepository extends Repository
{
    /**
     * Diese Variable wird von der Klasse Repository verwendet, um generische
     * Funktionen zur Verfügung zu stellen.
     */
    protected $tableName = 'user';

    /**
     * Erstellt einen neuen benutzer mit den gegebenen Werten.
     *
     * Das Passwort wird vor dem ausführen des Queries noch mit dem SHA2
     *  Algorythmus gehashed.
     *
     * @param $username Wert für die Spalte username
     * @param $first_name Wert für die Spalte firstName
     * @param $last_name Wert für die Spalte lastName
     * @param $email Wert für die Spalte email
     * @param $password Wert für die Spalte password
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     *
     * @return int Das id von generiertes User
     */
    public function create($username, $first_name, $last_name, $email, $password)
    {
        // Password validieren
        if(isset($password)) {
            // Passwort hashen
            $password = hash('sha256', $password);
        } else {
            header('/user/create?error=Es muss ein Passwort angegeben werden'); // Mit Fehler returnen, dass das PW leer war
        }

        // Eingabe validieren
        if(isset($username) && isset($first_name) && isset($last_name) && isset($email)) {
            if(!empty($username) && !empty($first_name) && !empty($last_name) && !isset($email)) {
                // Verhindert XSS
                htmlspecialchars($username);
                htmlspecialchars($first_name);
                htmlspecialchars($last_name);
                htmlspecialchars($email);
            } else {
                header('/user/create?error=Bitte lasse keine Eingabe leer'); // Mit Fehler returnen, dass Werte leer waren
            }
        } else {
            header('/user/create?error=Bitte gib überall einen Wert an'); // Mit Fehler returnen, dass Werte fehlen
        }

        $query = "INSERT INTO $this->tableName (username, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('sssss', $username, $first_name, $last_name, $email, $password);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

        return $statement->insert_id;
    }

    /**
     * Diese Funktion gibt den Datensatz mit dem gegebenen Benutzernamen zurück.
     *
     * @param $username Benutzername des gesuchten Datensatzes (einmalig)
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     *
     * @return Der gesuchte Datensatz oder null, sollte dieser nicht existieren
     */
    public function readByUsername($username)
    {
        if (!(isset($username) && !empty($username))) {
            return false;
        }
        htmlspecialchars($username);

        // Query erstellen
        $query = "SELECT * FROM {$this->tableName} WHERE username = ?";

        // Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
        // und die Parameter "binden"
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $username);

        // Das Statement absetzen
        $statement->execute();

        // Resultat der Abfrage holen
        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Ersten Datensatz aus dem Reultat holen
        $row = $result->fetch_object();

        // Datenbankressourcen wieder freigeben
        $result->close();

        // Den gefundenen Datensatz zurückgeben
        return $row;
    }
}
