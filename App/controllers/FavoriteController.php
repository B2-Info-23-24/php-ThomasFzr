<?php   
class FavoriteController{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function loadAccommodationFavorite()
    {
        if(isset($_SESSION['userID'])){
        require_once __DIR__ . '/../models/Favorite.php';
        $favorite = new Favorite();

        $tabAccommodation = $favorite->getFavorite($_SESSION['userID']);
        echo $this->twig->render('favoriteView.php', ['accommodations' => $tabAccommodation]);
        }else{
            header('Location: /connection');
        }
    }
}


?>