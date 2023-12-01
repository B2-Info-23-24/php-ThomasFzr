<?php


require_once __DIR__ . '/App/models/Database.php';
$database = new Database();
if ($database->createTables()) {
    $database->insertCity();
    $database->insertImage();
    $database->insertDataAccommodationTypeEquipmentService();
    $database->insertFakerDatas();
    $database->insertDataAccommodationEquipmentAccommodationService();
    $database->createAccounts();
    $database->createFavorite();
    $database->createReservation();
    $database->createReview();
}
