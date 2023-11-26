<?php
class DetailsTypesLogementController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    function getTypesLogement()
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Database.php';
            $db = new Database();
            $typesLogement = $db->getTypeLogement();

            echo $this->twig->render(
                'detailsTypesLogementView.php',
                [
                    'typesLogement' => $typesLogement,
                ]
            );
        } else {
            header('Location: /');
        }
    }
}
