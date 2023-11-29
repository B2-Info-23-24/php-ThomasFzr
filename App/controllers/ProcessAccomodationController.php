<?php
class ProcessAccomodationController
{

    private $accomodation;
    private $service;
    private $equipment;
    function __construct()
    {
        require_once __DIR__ . '/../models/Accomodation.php';
        require_once __DIR__ . '/../models/Service.php';
        require_once __DIR__ . '/../models/Equipment.php';
        $this->accomodation = new Accomodation();
        $this->service = new Service();
        $this->equipment = new Equipment();
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
            header("Location: /accomodation/$id");
        }
    }
    
    //Equipement
    function addEquipmentToAccomodation($id)
    {
        $this->equipment->addEquipmentToAccomodation($id, $_POST['equipmentID']);
        header("Location: /accomodation/$id");
    }

    function deleteEquipmentOfAccomodation($id)
    {
        if ($this->equipment->deleteEquipmentOfAccomodation($id, $_GET['equipmentID'])) {
            header("Location: /accomodation/$id");
        }
    }

    //Service
    function addServiceToAccomodation($id)
    {
        $this->service->addServiceToAccomodation($id, $_POST['serviceID']);
        header("Location: /accomodation/$id");
    }

    function deleteServiceOfAccomodation($id)
    {
        if ($this->service->deleteServiceOfAccomodation($id, $_GET['serviceID'])) {
            header("Location: /accomodation/$id");
        }
    }


    function processAccomodation($action, $id)
    {
        if (isset($_SESSION['isAdmin'])) {
            $process = new ProcessAccomodationController();

            switch ($action) {

                case 'addAccomodation':
                    $process->addAccomodation();
                    break;

                case 'deleteAccomodation':
                    $process->deleteAccomodation($id);
                    break;

                case 'addEquipment':
                    $process->addEquipmentToAccomodation($id);
                    break;

                case 'deleteEquipment':
                    $process->deleteEquipmentOfAccomodation($id);
                    break;

                case 'addService':
                    $process->addServiceToAccomodation($id);
                    break;

                case 'deleteService':
                    $process->deleteServiceOfAccomodation($id);
                    break;

                default:
                    break;
            }
        } else {
            header('Location: /connection');
        }
    }
}
