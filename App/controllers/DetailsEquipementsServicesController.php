<?php
class DetailsEquipementsServicesController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function getEquipementsServices()
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Database.php';
            $db = new Database();
            $equipements = $db->getEquipement();
            $services = $db->getService();

            echo $this->twig->render(
                'detailsEquipementsServicesView.php',
                [
                    'equipements' => $equipements,
                    'services' => $services
                ]
            );
        } else {
            header('Location: /');
        }
    }
}
