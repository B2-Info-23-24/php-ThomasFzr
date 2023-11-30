<?php


require_once __DIR__ . '/App/models/Database.php';
$database = new Database();
if ($database->createTables()) {
    $database->insertDataAccomodationTypeEquipmentService();
    $database->insertDataAccomodationEquipmentAccomodationService();
    $database->insertCity();
    $database->insertFakerDatas();
    $database->createAccounts();
    $database->insertImage();

}
