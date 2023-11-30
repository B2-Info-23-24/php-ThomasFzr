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
            $typeLogement = $_POST["accoType"];
            $image = null;
            if (isset($_POST["image"])) {
                $image = $_POST["image"];
            }
            $selectedEquipments = isset($_POST['selectedEquipments']) ? $_POST['selectedEquipments'] : [];
            $selectedServices = isset($_POST['selectedServices']) ? $_POST['selectedServices'] : [];

            if ($this->accomodation->insertAccomodation($title, $city, $price, $typeLogement, $image)) {
                $accomodationID = $this->accomodation->getLastAccomodationId();
                foreach ($selectedEquipments as $equipmentId) {
                    $this->equipment->addEquipmentToNewAccomodation($accomodationID, $equipmentId);
                }
                foreach ($selectedServices as $serciceId) {
                    $this->service->addServiceToNewAccomodation($accomodationID, $serciceId);
                }
                $_SESSION['successMsg'] = "Annonce ajoutée!";
                header('Location: /');
            } else {
                $_SESSION['errorMsg'] = "Annonce non ajoutée.";
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

    function modifyAccomodation($id)
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $successMsg = "";

            if (isset($_POST["price"]) && $_POST["price"] != '') {
                $this->accomodation->modifyAccomodation("price", $_POST["price"], $id);
                $successMsg = "Prix";
            }
            if (isset($_POST["title"]) && $_POST["title"] != '') {
                $this->accomodation->modifyAccomodation("title", $_POST["title"], $id);
                $successMsg = $successMsg . " Titre";
            }
            if (isset($_POST["city"]) && $_POST["city"] != '') {
                $this->accomodation->modifyAccomodation("city", $_POST["city"], $id);
                $successMsg = $successMsg . " Ville";
            }
            if (isset($_POST["image"]) && $_POST["image"] != '') {
                $this->accomodation->modifyAccomodation("image", $_POST["image"], $id);
                $successMsg = $successMsg . " Image";
            }
            if (isset($_POST["accoType"]) && $_POST["accoType"] != '') {
                $this->accomodation->modifyAccomodation("accomodationType", $_POST["accoType"], $id);
                $successMsg = $successMsg . " Type de logement";
            }

            if ((isset($_POST["title"]) && $_POST["title"] != '') || (isset($_POST["city"]) && $_POST["city"] != '')
                || (isset($_POST["price"]) && $_POST["price"] != '') || (isset($_POST["image"]) && $_POST["image"] != '')
                || (isset($_POST["accoType"]) && $_POST["accoType"] != '')
            ) {
                $_SESSION['successMsg'] = $successMsg . " changé avec succès";
            }

            header("Location: /accomodation/$id");
        } else {
            echo "Erreur edit info annonce";
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

                case 'modifyAccomodation':
                    $process->modifyAccomodation($id);
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
