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
            $db = new Database();
            $equipements = $db->getEquipment();
            $services = $db->getService();
            $typesLogement = $db->getAccomodationType();

            echo $this->twig->render(
                'detailsEquipmentServiceAccomodationType.php',
                [
                    'equipements' => $equipements,
                    'services' => $services,
                    'typesLogement' => $typesLogement
                ]
            );
        } else {
            header('Location: /');
        }
    }
}
