<?php
class DetailsAnnonceController
{
    private $twig;
    private $dateToday;
    private $dateTodayPlusOne;

    public function __construct($twig)
    {
        $this->twig = $twig;
        $this->dateToday = new DateTime('now');
        $this->dateTodayPlusOne = clone $this->dateToday;
        $this->dateTodayPlusOne->modify('+1 day');
        $this->dateToday = $this->dateToday->format('Y-m-d');
        $this->dateTodayPlusOne = $this->dateTodayPlusOne->format('Y-m-d');
    }



    public function getDetailsAnnonce($annonceID)
    {
        require_once __DIR__ . '/../models/Database.php';
        $database = new Database();

        $infoAnnonce = $database->getDetailsAnnonce($annonceID);
        $tabTypeLogement = $database->getTypeLogement();
        $tabService = $database->getService();
        $tabEquipement = $database->getEquipement();
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
            'typeLogements' => $tabTypeLogement,
            'services' => $tabService,
            'equipements' => $tabEquipement,
            'isInFavorite' => $isInFavorite,
            'tabAvis' => $tabAvis,
            'averageGrade' => $averageGrade,
            'dateToday' => $this->dateToday,
            'dateTodayPlusOne' => $this->dateTodayPlusOne,
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
