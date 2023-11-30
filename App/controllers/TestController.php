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
        // $database->insertDataAccomodationTypeEquipmentService();
        // $database->insertDataAccomodationEquipmentAccomodationService();
        // $database->insertCity();
        $database->insertFakerDatas();
        // $database->createAccounts();
        // $database->insertImage();
        header('Location: /');
    }
}
