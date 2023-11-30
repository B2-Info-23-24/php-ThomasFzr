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
        $database->createTables();
        $database->insertCity();
        $database->insertImage();

        $database->insertFakerDatas();
        $database->insertDataAccomodationTypeEquipmentService();
        $database->insertDataAccomodationEquipmentAccomodationService();

        $database->createAccounts();
        header('Location: /');
    }
}
