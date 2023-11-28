<?php
class ProcessFavoriteController
{

    private $favorite;
    function __construct()
    {
        require_once __DIR__ . '/../models/Favorite.php';
        $this->favorite = new Favorite();
    }

    function addToFavorite($id)
    {
        $this->favorite->addToFavorite($id);
        header("Location: /accomodation/$id");
    }

    function removeFromFavorite($id)
    {
        $this->favorite->removeFromFavorite($id);
        header("Location: /accomodation/$id");
    }


    function processFavorite($action, $id)
    {
        if (isset($_SESSION['userID'])) {
            $process = new ProcessFavoriteController();
            if ($action == "add") {
                $process->addToFavorite($id);
                $_SESSION['successMsg'] = "Logement ajouté en favoris";
            } elseif ($action == "remove") {
                $process->removeFromFavorite($id);
                $_SESSION['successMsg'] = "Logement retiré des favoris";
            }
        } else {
            header('Location: /connection');
        }
    }
}
