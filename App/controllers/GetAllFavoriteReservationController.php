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
            require_once __DIR__ . '/../models/User.php';
            require_once __DIR__ . '/../models/Accommodation.php';
            $user = new User();
            $accommodation = new Accommodation();
            $favorite = new Favorite();
            $reservation = new Reservation();


            $favorites = $favorite->getAllFavorite();
            $reservations = $reservation->getAllReservation();
            $users = $user->getAllUser();
            $accommodations = $accommodation->getAccommodation('');

            echo $this->twig->render(
                'allFavoriteReservationView.twig',
                [
                    'favorites' => $favorites,
                    'reservations' => $reservations,
                    'users' => $users,
                    'accommodations' => $accommodations
                ]
            );
        } else {
            header('Location: /connection');
        }
    }
}
