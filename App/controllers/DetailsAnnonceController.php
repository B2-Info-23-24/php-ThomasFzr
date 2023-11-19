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
        $tabTypeLogement = $database->getTypeLogement();
        $tabService = $database->getService();
        $tabEquipement = $database->getEquipement();
        $isInFavorite = $database->isInFavorite($annonceID);
        $tabAvis = $database->getCommentGradeFromAnnonce($annonceID);
        $averageGrade = $this->calculateAverageGrade($tabAvis);

        echo $this->twig->render('detailsAnnonceView.php', [
            'infoAnnonce' => $infoAnnonce,
            'typeLogements' => $tabTypeLogement,
            'services' => $tabService,
            'equipements' => $tabEquipement,
            'isInFavorite' => $isInFavorite,
            'tabAvis' => $tabAvis,
            'averageGrade' => $averageGrade,
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
