<?php   
class FavoriteController{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function loadAnnonceFavorite()
    {
        require_once __DIR__ . '/../models/Database.php';
        $database = new Database();

        $tabAnnonce = $database->getFavorite($_SESSION['userID']);
        echo $this->twig->render('favoriteView.php', ['annonces' => $tabAnnonce]);

    }
}


?>