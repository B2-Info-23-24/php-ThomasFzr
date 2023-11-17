<?php
class DetailsAnnonceController{
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
        echo $this->twig->render('detailsAnnonceView.php', ['infoAnnonce' => $infoAnnonce]);
    }

}
?>