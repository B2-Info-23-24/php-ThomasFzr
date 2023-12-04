<?php
class ActionFavoriteController
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
        header("Location: /accommodation/$id");
    }

    function removeFromFavorite($id)
    {
        $this->favorite->removeFromFavorite($id);
        header("Location: /accommodation/$id");
    }


    function actionFavorite($action, $id)
    {
        if (isset($_SESSION['userID'])) {
            $process = new ActionFavoriteController();
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
