<?php
class ProcessReservationController
{

    public function insertReservation($annonceID)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once __DIR__ . '/../models/Database.php';
            $db = new Database();
            if ($db->insertReservation($annonceID,  $_POST["dateDebut"], $_POST["dateFin"])) {
                $_SESSION['successMsg'] = "Réservation validée!";
                header("Location: /reservation");
            } else {
                header("Location: /detailsLogement/$annonceID");
            }
        }
    }
}
