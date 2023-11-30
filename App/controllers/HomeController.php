<?php
class HomeController
{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function getInfoHome($accomodationType, $selectedEquipments, $selectedServices, $city, $minPrice, $maxPrice, $accomodationTitle)
    {
        require_once __DIR__ . '/../models/Database.php';
        require_once __DIR__ . '/../models/Accomodation.php';
        require_once __DIR__ . '/../models/AccomodationType.php';
        require_once __DIR__ . '/../models/Equipment.php';
        require_once __DIR__ . '/../models/Service.php';

        $database = new Database();
        $accomodation = new Accomodation();
        $accoType = new AccomodationType();
        $equipment = new Equipment();
        $service = new Service();

        $conditions = [];

        if ($minPrice == '') {
            $minPrice = 0;
        }
        if ($maxPrice == '') {
            $maxPrice = 1000000;
        }
        $conditions[] = "price BETWEEN '$minPrice' AND '$maxPrice'";

        if ($accomodationType != '') {
            $conditions[] = "accomodationType = '$accomodationType'";
        }
        if ($accomodationTitle != '') {
            $conditions[] = " title like '%$accomodationTitle%'";
        }
        if ($city != '') {
            $conditions[] = "city = '$city'";
        }

        if (!empty($selectedEquipments)) {
            $equipmentsCondition = implode(',', $selectedEquipments);
            $nbEquipments = count($selectedEquipments);
            $conditions[] = "accomodationID IN (SELECT accomodationID FROM EquipmentAccomodation WHERE equipmentID IN ($equipmentsCondition)
                                            GROUP BY accomodationID
                                            HAVING COUNT(accomodationID) = $nbEquipments)";
        }
        if (!empty($selectedServices)) {
            $servicesCondition = implode(',', $selectedServices);
            $nbServices = count($selectedServices);
            $conditions[] = "accomodationID IN (SELECT accomodationID FROM ServiceAccomodation WHERE serviceID IN ($servicesCondition)
                                             GROUP BY accomodationID
                                            HAVING COUNT(accomodationID) = $nbServices)";
        }
        $whereClause = '';

        if (!empty($conditions)) {
            $whereClause = 'WHERE ' . implode(' AND ', $conditions);
        }
        //echo $whereClause; //TODO
        $tabAccomodation = $accomodation->getAccomodation($whereClause);
        $tabAccomodationType = $accoType->getAccomodationType();
        $tabService = $service->getService();
        $tabEquipment = $equipment->getEquipment();

        echo $this->twig->render(
            'home.php',
            [
                'accomodations' => $tabAccomodation,
                'accomodationTypes' => $tabAccomodationType,
                'services' => $tabService,
                'equipments' => $tabEquipment
            ]
        );
    }
}
