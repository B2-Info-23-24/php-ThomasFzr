<?php
class ReservationController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    //A modifier TODO
    function getReservation()
    {
        if (isset($_SESSION['userID'])) {
            echo $this->twig->render('reservationView.php');
        } else {
            header('Location: /connection');
        }
    }
}
