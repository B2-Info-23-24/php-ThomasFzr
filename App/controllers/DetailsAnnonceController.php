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
        $database = new Database();

        $infoAnnonce = $database->getDetailsAnnonce($annonceID);
        $tabService = $database->getServiceFromAnnonce($annonceID);
        $tabEquipement = $database->getEquipementFromAnnonce($annonceID);
        $tabAvis = $database->getCommentGradeFromAnnonce($annonceID);
        $averageGrade = $this->calculateAverageGrade($tabAvis);
        $userID = null;
        $isInFavorite = null;



        if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];
            $isInFavorite = $database->isInFavorite($annonceID);
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
