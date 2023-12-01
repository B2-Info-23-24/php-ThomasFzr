<?php
class ReservationController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function getReservation()
    {
        if (isset($_SESSION['userID'])) {
            require_once __DIR__ . '/../models/Reservation.php';
            $reservation = new Reservation();

            $dateToday = new DateTime('now');
            $dateToday = $dateToday->format('Y-m-d');

            $tabAccommodationReservation = $reservation->getReservation($_SESSION['userID']);
            echo $this->twig->render('reservationView.php', [
                'accommodationReservation' => $tabAccommodationReservation,
                'dateToday' => $dateToday
            ]);
        } else {
            header('Location: /connection');
        }
    }
}
