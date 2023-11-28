<?php


require_once __DIR__ . '/App/models/Database.php';
$database = new Database();
if ($database->createTables()) {
    $database->insertFakerDatas();
    $database->insertDataAccomodationTypeEquipmentService();
    $database->insertDataAccomodationEquipmentAccomodationService();
    $database->createAccounts();

}
