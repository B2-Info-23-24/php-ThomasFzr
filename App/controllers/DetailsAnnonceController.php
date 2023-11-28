<?php
class DetailsAnnonceController
{
    private $twig;


    public function __construct($twig)
    {
        $this->twig = $twig;
    }



    public function getDetailsAnnonce($annonceID)
    {
        require_once __DIR__ . '/../models/Database.php';
        require_once __DIR__ . '/../models/Favorite.php';
        require_once __DIR__ . '/../models/Review.php';
        require_once __DIR__ . '/../models/Accomodation.php';

        $database = new Database();
        $favorite = new Favorite();
        $review = new Review();
        $accomodation = new Accomodation();

        $infoAnnonce = $accomodation->getDetailsAnnonce($annonceID);
        $tabService = $database->getServiceFromAnnonce($annonceID);
        $tabEquipement = $database->getEquipementFromAnnonce($annonceID);
        $tabAvis = $review->getReviewFromAnnonce($annonceID);
        $averageGrade = $this->calculateAverageGrade($tabAvis);
        $userID = null;
        $isInFavorite = null;



        if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];
            $isInFavorite = $favorite->isInFavorite($annonceID);
        }
        echo $this->twig->render('detailsAnnonceView.php', [
            'infoAnnonce' => $infoAnnonce,
            'services' => $tabService,
            'equipements' => $tabEquipement,
            'isInFavorite' => $isInFavorite,
            'tabAvis' => $tabAvis,
            'averageGrade' => $averageGrade,
            'userID' => $userID
        ]);
    }

    private function calculateAverageGrade($tabAvis)
    {
        if (empty($tabAvis)) {
            return null;
        }
        $totalGrade = 0;
        foreach ($tabAvis as $avis) {
            $totalGrade += $avis['grade'];
        }
        $averageGrade = $totalGrade / count($tabAvis);
        return number_format($averageGrade, 1);
    }
}
