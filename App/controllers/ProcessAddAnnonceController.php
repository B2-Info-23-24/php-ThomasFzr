<?php
class ProcessAddAnnonceController
{

    public function addAnnonce()
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Database.php';
            $db = new Database();


            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $title = $_POST["title"];
                $city = $_POST["city"];
                $price = $_POST["price"];
                $typeLogement = $_POST["typeLogement"];
                $image = null;
                if (isset($_POST["image"])) {
                    $image = $_POST["image"];
                }

                if ($db->insertAnnonce($title, $city, $price, $typeLogement, $image)) {
                    header('Location: /');
                } else {
                    header('Location: /addAnnonce');
                }
            }
        } else {
            header('Location: /');
        }
    }
}
