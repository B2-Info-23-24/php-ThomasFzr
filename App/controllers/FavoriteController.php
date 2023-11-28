<?php   
class FavoriteController{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function loadAccomodationFavorite()
    {
        if(isset($_SESSION['userID'])){
        require_once __DIR__ . '/../models/Favorite.php';
        $favorite = new Favorite();

        $tabAccomodation = $favorite->getFavorite($_SESSION['userID']);
        echo $this->twig->render('favoriteView.php', ['accomodations' => $tabAccomodation]);
        }else{
            header('Location: /connection');
        }
    }
}


?>