<?php
class ProcessAnnonceController
{

    private $accomodation;
    function __construct()
    {
        require_once __DIR__ . '/../models/Accomodation.php';
        $this->accomodation = new Accomodation();
    }

    public function addAnnonce()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $city = $_POST["city"];
            $price = $_POST["price"];
            $typeLogement = $_POST["typeLogement"];
            $image = null;
            if (isset($_POST["image"])) {
                $image = $_POST["image"];
            }

            if ($this->accomodation->insertAnnonce($title, $city, $price, $typeLogement, $image)) {
                header('Location: /');
            } else {
                header('Location: /addAnnonce');
            }
        }
    }

    function deleteAnnonce($id)
    {
        if ($this->accomodation->deleteAnnonce($id)) {
            header("Location: /");
        } else {
            header("Location: /detailsLogement/$id");
        }
    }


    function processAnnonce($action, $id)
    {
        if (isset($_SESSION['isAdmin'])) {
            $process = new ProcessAnnonceController();
            if ($action == "add") {
                $process->addAnnonce();
            } elseif ($action == "delete") {
                $process->deleteAnnonce($id);
            }
        } else {
            header('Location: /connection');
        }
    }
}
