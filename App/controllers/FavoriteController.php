<?php   
class FavoriteController{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function loadAnnonceFavorite()
    {
        if(isset($_SESSION['userID'])){
        require_once __DIR__ . '/../models/Favorite.php';
        $favorite = new Favorite();

        $tabAnnonce = $favorite->getFavorite($_SESSION['userID']);
        echo $this->twig->render('favoriteView.php', ['annonces' => $tabAnnonce]);
        }else{
            header('Location: /connection');
        }
    }
}


?>