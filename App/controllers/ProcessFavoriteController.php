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
                $process->addFavorite($favoriteID);
                $_SESSION['successMsg'] = "Logement ajouté en favoris";
            } elseif ($action == "delete") {
                $process->deleteFavorite($favoriteID);
                $_SESSION['successMsg'] = "Logement retiré des favoris";
            }
        } else {
            header('Location: /connection');
        }
    }
}
