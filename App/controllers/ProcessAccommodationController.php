<?php
class ProcessAccommodationController
{

    private $accommodation;
    private $service;
    private $equipment;
    function __construct()
    {
        require_once __DIR__ . '/../models/Accommodation.php';
        require_once __DIR__ . '/../models/Service.php';
        require_once __DIR__ . '/../models/Equipment.php';
        $this->accommodation = new Accommodation();
        $this->service = new Service();
        $this->equipment = new Equipment();
    }

    public function addAccommodation()
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

            if ($this->accommodation->insertAccommodation($title, $city, $price, $typeLogement, $image)) {
                $accommodationID = $this->accommodation->getLastAccommodationId();
                foreach ($selectedEquipments as $equipmentId) {
                    $this->equipment->addEquipmentToNewAccommodation($accommodationID, $equipmentId);
                }
                foreach ($selectedServices as $serciceId) {
                    $this->service->addServiceToNewAccommodation($accommodationID, $serciceId);
                }
                $_SESSION['successMsg'] = "Annonce ajoutée!";
                header('Location: /');
            } else {
                $_SESSION['errorMsg'] = "Annonce non ajoutée.";
                header('Location: /addAnnonce');
            }
        }
    }

    function deleteAccommodation($id)
    {
        if ($this->accommodation->deleteAccommodation($id)) {
            header("Location: /");
        } else {
            header("Location: /accommodation/$id");
        }
    }

    //Equipement
    function addEquipmentToAccommodation($id)
    {
        $this->equipment->addEquipmentToAccommodation($id, $_POST['equipmentID']);
        header("Location: /accommodation/$id");
    }

    function deleteEquipmentOfAccommodation($id)
    {
        if ($this->equipment->deleteEquipmentOfAccommodation($id, $_GET['equipmentID'])) {
            header("Location: /accommodation/$id");
        }
    }

    //Service
    function addServiceToAccommodation($id)
    {
        $this->service->addServiceToAccommodation($id, $_POST['serviceID']);
        header("Location: /accommodation/$id");
    }

    function deleteServiceOfAccommodation($id)
    {
        if ($this->service->deleteServiceOfAccommodation($id, $_GET['serviceID'])) {
            header("Location: /accommodation/$id");
        }
    }

    function modifyAccommodation($id)
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $successMsg = "";

            if (isset($_POST["price"]) && $_POST["price"] != '') {
                $this->accommodation->modifyAccommodation("price", $_POST["price"], $id);
                $successMsg = "Prix";
            }
            if (isset($_POST["title"]) && $_POST["title"] != '') {
                $this->accommodation->modifyAccommodation("title", $_POST["title"], $id);
                $successMsg = $successMsg . " Titre";
            }
            if (isset($_POST["city"]) && $_POST["city"] != '') {
                $this->accommodation->modifyAccommodation("city", $_POST["city"], $id);
                $successMsg = $successMsg . " Ville";
            }
            if (isset($_POST["image"]) && $_POST["image"] != '') {
                $this->accommodation->modifyAccommodation("image", $_POST["image"], $id);
                $successMsg = $successMsg . " Image";
            }
            if (isset($_POST["accoType"]) && $_POST["accoType"] != '') {
                $this->accommodation->modifyAccommodation("accommodationType", $_POST["accoType"], $id);
                $successMsg = $successMsg . " Type de logement";
            }

            if ((isset($_POST["title"]) && $_POST["title"] != '') || (isset($_POST["city"]) && $_POST["city"] != '')
                || (isset($_POST["price"]) && $_POST["price"] != '') || (isset($_POST["image"]) && $_POST["image"] != '')
                || (isset($_POST["accoType"]) && $_POST["accoType"] != '')
            ) {
                $_SESSION['successMsg'] = $successMsg . " changé avec succès";
            }

            header("Location: /accommodation/$id");
        } else {
            echo "Erreur edit info annonce";
        }
    }

    function processAccommodation($action, $id)
    {
        if (isset($_SESSION['isAdmin'])) {
            $process = new ProcessAccommodationController();

            switch ($action) {

                case 'addAccommodation':
                    $process->addAccommodation();
                    break;

                case 'modifyAccommodation':
                    $process->modifyAccommodation($id);
                    break;

                case 'deleteAccommodation':
                    $process->deleteAccommodation($id);
                    break;

                case 'addEquipment':
                    $process->addEquipmentToAccommodation($id);
                    break;

                case 'deleteEquipment':
                    $process->deleteEquipmentOfAccommodation($id);
                    break;

                case 'addService':
                    $process->addServiceToAccommodation($id);
                    break;

                case 'deleteService':
                    $process->deleteServiceOfAccommodation($id);
                    break;

                default:
                    break;
            }
        } else {
            header('Location: /connection');
        }
    }
}
