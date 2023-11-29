<?php
class ProcessAccomodationTypeController
{
    private $accoType;
    function __construct()
    {
        require_once __DIR__ . '/../models/AccomodationType.php';
        $this->accoType = new AccomodationType();
    }

    public function addAccomodationType()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $accoTypeName = $_POST["accoTypeName"];
            if ($this->accoType->addAccomodationType($accoTypeName)) {
                header('Location: /allEquipmentServiceAccomodationType');
            }
        }
    }

    function deleteAccomodationType($id)
    {
        if ($this->accoType->deleteAccomodationType($id)) {
            header("Location: /allEquipmentServiceAccomodationType");
        }
    }

    function modifyAccomodationType($id)
    {
        $value = $_POST['accoTypeName'];
        if ($this->accoType->modifyAccomodationType($value, $id)) {
            header("Location: /allEquipmentServiceAccomodationType");
        }
    }


    function processAccomodationType($action, $id)
    {
        if (isset($_SESSION['isAdmin'])) {
            $process = new ProcessAccomodationTypeController();
            if ($action == "add") {
                $process->addAccomodationType();
            } elseif ($action == "delete") {
                $process->deleteAccomodationType($id);
            } elseif ($action == "modify") {
                $process->modifyAccomodationType($id);
            }
        } else {
            header('Location: /connection');
        }
    }
}
