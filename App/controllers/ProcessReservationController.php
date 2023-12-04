<?php
class ProcessReservationController
{

    private $reservation;
    function __construct()
    {
        require_once __DIR__ . '/../models/Reservation.php';
        $this->reservation = new Reservation();
    }

    public function deleteReservation($reservationID)
    {
        $this->reservation->deleteReservation($reservationID);
        header("Location: /allFavoritesReservations");
    }

    public function addReservation()
    {
        require_once __DIR__ . '/../models/Accommodation.php';
        $accommodation = new Accommodation();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {


            $accommodationID = $_POST["accommodationID"];
            $userID = $_POST["userID"];
            $startDate = new DateTime($_POST["startDate"]);
            $endDate = new DateTime($_POST["endDate"]);
            $pricePerDay = $accommodation->getPriceOfAccommodation($accommodationID);
            $interval = $startDate->diff($endDate);
            $durationInDays = $interval->days;
            $totalPrice = $durationInDays * $pricePerDay;

            if ($this->reservation->insertReservation($accommodationID,  $_POST["startDate"], $_POST["endDate"], $totalPrice, $userID)) {
                $_SESSION['successMsg'] = "Réservation ajoutée!";
            }
        }
        header("Location: /allFavoritesReservations");
    }

    function processReservation($action, $reservationID)
    {
        if (isset($_SESSION['isAdmin'])) {
            $process = new ProcessReservationController();
            if ($action == "add") {
                $process->addReservation();
            } elseif ($action == "delete") {
                $process->deleteReservation($reservationID);
            }
        } else {
            header('Location: /connection');
        }
    }
}
