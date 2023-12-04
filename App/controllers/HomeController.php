<?php
class HomeController
{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function getInfoHome($accommodationType, $selectedEquipments, $selectedServices, $city, $minPrice, $maxPrice, $accommodationTitle)
    {
        require_once __DIR__ . '/../models/Database.php';
        require_once __DIR__ . '/../models/Accommodation.php';
        require_once __DIR__ . '/../models/AccommodationType.php';
        require_once __DIR__ . '/../models/Equipment.php';
        require_once __DIR__ . '/../models/Service.php';

        $database = new Database();
        $accommodation = new Accommodation();
        $accoType = new AccommodationType();
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

        if ($accommodationType != '') {
            $conditions[] = "accommodationType = '$accommodationType'";
        }
        if ($accommodationTitle != '') {
            $conditions[] = " title like '%$accommodationTitle%'";
        }
        if ($city != '') {
            $conditions[] = "city = '$city'";
        }

        if (!empty($selectedEquipments)) {
            $equipmentsCondition = implode(',', $selectedEquipments);
            $nbEquipments = count($selectedEquipments);
            $conditions[] = "accommodationID IN (SELECT accommodationID FROM EquipmentAccommodation WHERE equipmentID IN ($equipmentsCondition)
                                            GROUP BY accommodationID
                                            HAVING COUNT(accommodationID) = $nbEquipments)";
        }
        if (!empty($selectedServices)) {
            $servicesCondition = implode(',', $selectedServices);
            $nbServices = count($selectedServices);
            $conditions[] = "accommodationID IN (SELECT accommodationID FROM ServiceAccommodation WHERE serviceID IN ($servicesCondition)
                                             GROUP BY accommodationID
                                            HAVING COUNT(accommodationID) = $nbServices)";
        }
        $whereClause = '';

        if (!empty($conditions)) {
            $whereClause = 'WHERE ' . implode(' AND ', $conditions);
        }
        //echo $whereClause; //TODO
        $tabAccommodation = $accommodation->getAccommodation($whereClause);
        $tabAccommodationType = $accoType->getAccommodationType();
        $tabService = $service->getService();
        $tabEquipment = $equipment->getEquipment();

        echo $this->twig->render(
            'home.twig',
            [
                'accommodations' => $tabAccommodation,
                'accommodationTypes' => $tabAccommodationType,
                'services' => $tabService,
                'equipments' => $tabEquipment
            ]
        );
    }
}
