<?php
class AddReservationController
{

    public function insertReservation($accommodationID)
    {
        if (isset($_SESSION['userID'])) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                require_once __DIR__ . '/../models/Reservation.php';
                $reservation = new Reservation();
                $startDate = new DateTime($_POST["startDate"]);
                $endDate = new DateTime($_POST["endDate"]);
                $pricePerDay = $_POST['price'];
                $interval = $startDate->diff($endDate);
                $durationInDays = $interval->days;
                $totalPrice = $durationInDays * $pricePerDay;

                if ($reservation->insertReservation($accommodationID,  $_POST["startDate"], $_POST["endDate"], $totalPrice)) {
                    $_SESSION['successMsg'] = "Réservation validée!";
                    header("Location: /myReservations");
                } else {
                    header("Location: /accommodation/$accommodationID");
                }
            }
        } else {
            header('Location: /connection');
        }
    }
}
