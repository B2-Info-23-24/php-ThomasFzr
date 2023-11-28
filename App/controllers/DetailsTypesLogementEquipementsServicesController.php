<?php
class DetailsTypesLogementEquipementsServicesController
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
            $equipements = $db->getEquipement();
            $services = $db->getService();
            $typesLogement = $db->getTypeLogement();

            echo $this->twig->render(
                'detailsEquipementsServicesView.php',
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
