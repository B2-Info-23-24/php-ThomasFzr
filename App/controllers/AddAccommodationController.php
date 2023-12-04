<?php
class AddAccommodationController
{
    private $twig;
    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function AddAccommodation()
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Database.php';
            require_once __DIR__ . '/../models/AccommodationType.php';
            require_once __DIR__ . '/../models/Service.php';
            require_once __DIR__ . '/../models/Equipment.php';
            $database = new Database();
            $accoType = new AccommodationType();
            $service = new Service();
            $equipment = new Equipment();

            $accommodationTypes = $accoType->getAccommodationType();
            $equipments = $equipment->getEquipment();
            $services = $service->getService();
            $allImages = $database->getImage();
            $allCities = $database->getCity();

            echo $this->twig->render(
                'addAccommodationView.twig',
                [
                    'accommodationTypes' => $accommodationTypes,
                    'equipments' => $equipments,
                    'services' => $services,
                    'allImages' => $allImages,
                    'allCities' => $allCities
                ]
            );
        } else {
            header('Location: /connection');
        }
    }
}
