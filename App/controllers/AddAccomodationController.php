<?php
class AddAccomodationController
{
    private $twig;
    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function AddAccomodation()
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/AccomodationType.php';
            require_once __DIR__ . '/../models/Service.php';
            require_once __DIR__ . '/../models/Equipment.php';
            $accoType = new AccomodationType();
            $service = new Service();
            $equipment = new Equipment();

            $accomodationTypes = $accoType->getAccomodationType();
            $equipments = $equipment->getEquipment();
            $services = $service->getService();

            echo $this->twig->render(
                'addAccomodationView.php',
                [
                    'accomodationTypes' => $accomodationTypes,
                    'equipments' => $equipments,
                    'services' => $services
                ]
            );
        } else {
            header('Location: /');
        }
    }
}
