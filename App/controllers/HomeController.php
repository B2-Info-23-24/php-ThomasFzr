<?php
class HomeController
{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function getInfoHome($typeLogement, $selectedEquipements, $selectedServices, $ville)
    {
        require_once __DIR__ . '/../models/Database.php';
        $database = new Database();
        $conditions = [];

        if ($typeLogement != '') {
            $conditions[] = "typeLogement = '$typeLogement'";
        }
        if ($ville != '') {
            $conditions[] = "ville = '$ville'";
        }
        if (!empty($selectedEquipements)) {
            $equipementsCondition = implode(',', $selectedEquipements);
            $conditions[] = "annonceID IN (SELECT annonceID FROM EquipementAnnonce WHERE equipementID IN ($equipementsCondition))";
        }
        if (!empty($selectedServices)) {
            $servicesCondition = implode(',', $selectedServices);
            $conditions[] = "annonceID IN (SELECT annonceID FROM ServiceAnnonce WHERE serviceID IN ($servicesCondition))";
        }
        $whereClause = '';

        if (!empty($conditions)) {
            $whereClause = 'WHERE ' . implode(' AND ', $conditions);
        }

        $tabAnnonce = $database->getAnnonce($whereClause);
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
