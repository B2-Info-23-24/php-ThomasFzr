<?php
class ProcessEquipmentController
{
    private $equipment;
    function __construct()
    {
        require_once __DIR__ . '/../models/Equipment.php';
        $this->equipment = new Equipment();
    }

    public function addEquipment()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $equipmentName = $_POST["equipmentName"];
            if ($this->equipment->addEquipment($equipmentName)) {
                header('Location: /allEquipmentServiceAccommodationType');
            }
        }
    }

    function deleteEquipment($id)
    {
        if ($this->equipment->deleteEquipment($id)) {
            header("Location: /allEquipmentServiceAccommodationType");
        }
    }

    function modifyEquipment($id)
    {
        $value = $_POST['equipmentName'];
        if ($this->equipment->modifyEquipment($value, $id)) {
            header("Location: /allEquipmentServiceAccommodationType");
        }
    }


    function processEquipment($action, $id)
    {
        if (isset($_SESSION['isAdmin'])) {
            $process = new ProcessEquipmentController();
            if ($action == "add") {
                $process->addEquipment();
            } elseif ($action == "delete") {
                $process->deleteEquipment($id);
            } elseif ($action == "modify") {
                $process->modifyEquipment($id);
            }
        } else {
            header('Location: /connection');
        }
    }
}
