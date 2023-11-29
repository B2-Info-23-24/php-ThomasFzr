<?php
class ProcessAccomodationController
{

    private $accomodation;
    function __construct()
    {
        require_once __DIR__ . '/../models/Accomodation.php';
        $this->accomodation = new Accomodation();
    }

    public function addAccomodation()
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

            if ($this->accomodation->insertAccomodation($title, $city, $price, $typeLogement, $image)) {
                header('Location: /');
            } else {
                header('Location: /addAnnonce');
            }
        }
    }

    function deleteAccomodation($id)
    {
        if ($this->accomodation->deleteAccomodation($id)) {
            header("Location: /");
        } else {
            header("Location: /detailsLogement/$id");
        }
    }


    function processAccomodation($action, $id)
    {
        if (isset($_SESSION['isAdmin'])) {
            $process = new ProcessAccomodationController();
            if ($action == "add") {
                $process->addAccomodation();
            } elseif ($action == "delete") {
                $process->deleteAccomodation($id);
            }
        } else {
            header('Location: /connection');
        }
    }
}
