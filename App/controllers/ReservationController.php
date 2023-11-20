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
            require_once __DIR__ . '/../models/Database.php';
            $database = new Database();

            $tabAnnonce = $database->getReservation($_SESSION['userID']);
            echo $this->twig->render('reservationView.php', ['annonces' => $tabAnnonce]);
        } else {
            header('Location: /connection');
        }
    }
}
