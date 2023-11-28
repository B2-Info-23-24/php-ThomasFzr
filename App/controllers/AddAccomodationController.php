<?php
class AddAnnonceController
{
    private $twig;
    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function addAnnonce()
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Database.php';
            $db = new Database();
            $typesLogement = $db->getAccomodationType();
            $equipments = $db->getEquipment();
            $services = $db->getService();

            echo $this->twig->render(
                'addAccomodationView.php',
                [
                    'typesLogement' => $typesLogement,
                    'equipments' => $equipments,
                    'services' => $services
                ]
            );
        } else {
            header('Location: /');
        }
    }
}
