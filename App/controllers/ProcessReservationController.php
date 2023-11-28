<?php
class ProcessReservationController
{

    public function insertReservation($annonceID)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once __DIR__ . '/../models/Reservation.php';
            $reservation = new Reservation();
            if ($reservation->insertReservation($annonceID,  $_POST["dateDebut"], $_POST["dateFin"])) {
                $_SESSION['successMsg'] = "Réservation validée!";
                header("Location: /reservation");
            } else {
                header("Location: /detailsLogement/$annonceID");
            }
        }
    }
}
