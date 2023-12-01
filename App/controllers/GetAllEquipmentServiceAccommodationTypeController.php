<?php
class GetAllEquipmentServiceAccommodationTypeController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function getTypesLogementEquipementsServices()
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Database.php';
            require_once __DIR__ . '/../models/AccommodationType.php';
            require_once __DIR__ . '/../models/Service.php';
            require_once __DIR__ . '/../models/Equipment.php';
            $db = new Database();
            $accoType = new AccommodationType();
            $service = new Service();
            $equipment = new Equipment();

            $equipements = $equipment->getEquipment();
            $services = $service->getService();
            $typesLogement = $accoType->getAccommodationType();

            echo $this->twig->render(
                'allEquipmentServiceAccommodationTypeView.php',
                [
                    'equipments' => $equipements,
                    'services' => $services,
                    'accommodationTypes' => $typesLogement
                ]
            );
        } else {
            header('Location: /connection');
        }
    }
}
