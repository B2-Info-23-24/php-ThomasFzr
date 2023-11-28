<?php
class ProcessReservationController
{

    public function insertReservation($accomodationID)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once __DIR__ . '/../models/Reservation.php';
            $reservation = new Reservation();
            $startDate = new DateTime($_POST["startDate"]);
            $endDate = new DateTime($_POST["endDate"]);
            $pricePerDay = $_POST['price'];
            $interval = $startDate->diff($endDate);
            $durationInDays = $interval->days;
            $totalPrice = $durationInDays * $pricePerDay;

            if ($reservation->insertReservation($accomodationID,  $_POST["startDate"], $_POST["endDate"], $totalPrice)) {
                $_SESSION['successMsg'] = "Réservation validée!";
                header("Location: /myReservations");
            } else {
                header("Location: /accomodation/$accomodationID");
            }
        }
    }
}
