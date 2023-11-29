<?php
class DetailsEquipmentServiceAccomodationTypeController
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
            require_once __DIR__ . '/../models/AccomodationType.php';
            require_once __DIR__ . '/../models/Service.php';
            require_once __DIR__ . '/../models/Equipment.php';
            $db = new Database();
            $accoType = new AccomodationType();
            $service = new Service();
            $equipment = new Equipment();

            $equipements = $equipment->getEquipment();
            $services = $service->getService();
            $typesLogement = $accoType->getAccomodationType();

            echo $this->twig->render(
                'detailsEquipmentServiceAccomodationType.php',
                [
                    'equipments' => $equipements,
                    'services' => $services,
                    'accomodationTypes' => $typesLogement
                ]
            );
        } else {
            header('Location: /');
        }
    }
}
