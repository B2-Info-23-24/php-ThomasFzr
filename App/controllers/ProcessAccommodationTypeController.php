<?php
class ProcessAccommodationTypeController
{
    private $accoType;
    function __construct()
    {
        require_once __DIR__ . '/../models/AccommodationType.php';
        $this->accoType = new AccommodationType();
    }

    public function addAccommodationType()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $accoTypeName = $_POST["accoTypeName"];
            if ($this->accoType->addAccommodationType($accoTypeName)) {
                header('Location: /allEquipmentServiceAccommodationType');
            }
        }
    }

    function deleteAccommodationType($id)
    {
        if ($this->accoType->deleteAccommodationType($id)) {
            header("Location: /allEquipmentServiceAccommodationType");
        }
    }

    function modifyAccommodationType($id)
    {
        $value = $_POST['accoTypeName'];
        if ($this->accoType->modifyAccommodationType($value, $id)) {
            header("Location: /allEquipmentServiceAccommodationType");
        }
    }


    function processAccommodationType($action, $id)
    {
        if (isset($_SESSION['isAdmin'])) {
            $process = new ProcessAccommodationTypeController();
            if ($action == "add") {
                $process->addAccommodationType();
            } elseif ($action == "delete") {
                $process->deleteAccommodationType($id);
            } elseif ($action == "modify") {
                $process->modifyAccommodationType($id);
            }
        } else {
            header('Location: /connection');
        }
    }

    
}
