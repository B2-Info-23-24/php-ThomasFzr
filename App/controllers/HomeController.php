<?php
class HomeController
{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function getInfoHome($typeLogement)
    {
        require_once __DIR__ . '/../models/Database.php';
        $database = new Database();
        $rqt = "";
        if ($typeLogement != '') {
            $rqt = "WHERE typeLogement = '$typeLogement'";
        }


        $tabAnnonce = $database->getAnnonce($rqt);
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
