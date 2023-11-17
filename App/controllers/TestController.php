<?php
class TestController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }
    public function test()
    {
        require_once __DIR__ . '/../models/Database.php';
        $database = new Database();

        $infoAnnonce = $database->getDetailsAnnonce(1);
        echo $this->twig->render('detailsAnnonceView.php', ['infoAnnonce' => $infoAnnonce]);

    }
}

