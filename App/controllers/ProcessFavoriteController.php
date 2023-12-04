<?php
class ProcessFavoriteController
{
    private $favorite;
    function __construct()
    {
        require_once __DIR__ . '/../models/Favorite.php';
        $this->favorite = new Favorite();
    }

    function addFavorite()
    {
        $this->favorite->addFavorite($_POST["userID"], $_POST["accommodationID"]);
        header("Location: /allFavoritesReservations");
    }

    function deleteFavorite($favoriteID)
    {
        $this->favorite->deleteFavorite($favoriteID);
        header("Location: /allFavoritesReservations");
    }

    function processFavorite($action, $favoriteID)
    {
        if (isset($_SESSION['isAdmin'])) {
            $process = new ProcessFavoriteController();
            if ($action == "add") {
                $process->addFavorite();
            } elseif ($action == "delete") {
                $process->deleteFavorite($favoriteID);
            }
        } else {
            header('Location: /connection');
        }
    }
}
