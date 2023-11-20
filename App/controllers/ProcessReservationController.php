<?php
class ProcessReservationController
{

    public function insertReservation($annonceID)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once __DIR__ . '/../models/Database.php';
            $db = new Database();
            $db->insertReservation($annonceID,  $_POST["dateDebut"], $_POST["dateFin"]);

            //Aller dans mes reservations TODO
            header("Location: /reservation");
        }
    }
}
