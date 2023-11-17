<?php
class HomeController
{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function loadAnnonce()
    {
        require_once __DIR__ . '/../models/Database.php';
        $database = new Database();

        $tabAnnonce = $database->getAnnonce();
        $tabTypeLogement = $database->getTypeLogement();
        $tabService = $database->getService();
        $tabEquipement = $database->getEquipement();
        echo $this->twig->render(
            'home.php',
            [
                'annonces' => $tabAnnonce,
                'typeLogements' => $tabTypeLogement,
                'services' => $tabService,
                'equipements' => $tabEquipement
            ]
        );
    }
}
