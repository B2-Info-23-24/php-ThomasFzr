<?php
class ProcessAvisController
{


    public function insertAvis($annonceID)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once __DIR__ . '/../models/Database.php';
            $db = new Database();

            $date = new DateTime('now');
            $date = $date->format('Y-m-d');

            $db->insertAvis($annonceID,  $_POST["grade"], $_POST["comment"], $date);

            header("Location: /detailsLogement/$annonceID");
        }
    }
}