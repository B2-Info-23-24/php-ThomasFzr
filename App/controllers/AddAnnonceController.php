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
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        $typesLogement = $db->getTypeLogement();
        $equipements = $db->getEquipement();
        $services = $db->getService();

        echo $this->twig->render(
            'addAnnonceView.php',
            [
                'typesLogement' => $typesLogement,
                'equipements' => $equipements,
                'services' => $services
            ]
        );
    }
}
