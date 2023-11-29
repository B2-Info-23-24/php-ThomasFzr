<?php
class GetAllFavoriteReservationController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function getTypesLogementEquipementsServices()
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Favorite.php';
            require_once __DIR__ . '/../models/Reservation.php';
           
            $favorite = new Favorite();
            $reservation = new Reservation();
       

            $favorites = $favorite->getAllFavorite();
            $reservations = $reservation->getAllReservation();
       

            echo $this->twig->render(
                'allFavoriteReservationView.php',
                [
                    'favorites' => $favorites,
                    'reservations' => $reservations,
                ]
            );
        } else {
            header('Location: /connection');
        }
    }
}
