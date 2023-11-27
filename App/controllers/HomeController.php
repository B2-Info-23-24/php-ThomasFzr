<?php
class HomeController
{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function getInfoHome($typeLogement, $selectedEquipements, $selectedServices, $city, $minPrice, $maxPrice)
    {
        require_once __DIR__ . '/../models/Database.php';
        $database = new Database();
        $conditions = [];

        if ($minPrice == '') {
            $minPrice = 100;
        }
        if ($maxPrice == '') {
            $maxPrice = 1000;
        }
        $conditions[] = "price BETWEEN '$minPrice' AND '$maxPrice'";

        if ($typeLogement != '') {
            $conditions[] = "typeLogement = '$typeLogement'";
        }
        if ($city != '') {
            $conditions[] = "city = '$city'";
        }

        if (!empty($selectedEquipements)) {
            $equipementsCondition = implode(',', $selectedEquipements);
            $nbEquipements = count($selectedEquipements);
            $conditions[] = "annonceID IN (SELECT annonceID FROM EquipementAnnonce WHERE equipementID IN ($equipementsCondition)
                                            GROUP BY annonceID
                                            HAVING COUNT(annonceID) = $nbEquipements)";
        }
        if (!empty($selectedServices)) {
            $servicesCondition = implode(',', $selectedServices);
            $nbServices = count($selectedServices);
            $conditions[] = "annonceID IN (SELECT annonceID FROM ServiceAnnonce WHERE serviceID IN ($servicesCondition)
                                             GROUP BY annonceID
                                            HAVING COUNT(annonceID) = $nbServices)";
        }
        $whereClause = '';

        if (!empty($conditions)) {
            $whereClause = 'WHERE ' . implode(' AND ', $conditions);
        }
        // echo $whereClause; //TODO
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
