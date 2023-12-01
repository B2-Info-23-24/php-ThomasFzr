<?php
class ProcessServiceController
{
    private $service;
    function __construct()
    {
        require_once __DIR__ . '/../models/Service.php';
        $this->service = new Service();
    }

    public function addService()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $serviceName = $_POST["serviceName"];
            if ($this->service->addService($serviceName)) {
                header('Location: /allEquipmentServiceAccommodationType');
            }
        }
    }

    function deleteService($id)
    {
        if ($this->service->deleteService($id)) {
            header("Location: /allEquipmentServiceAccommodationType");
        }
    }

    function modifyService($id)
    {
        $value = $_POST['serviceName'];
        if ($this->service->modifyService($value, $id)) {
            header("Location: /allEquipmentServiceAccommodationType");
        }
    }


    function processService($action, $id)
    {
        if (isset($_SESSION['isAdmin'])) {
            $process = new ProcessServiceController();
            if ($action == "add") {
                $process->addService();
            } elseif ($action == "delete") {
                $process->deleteService($id);
            } elseif ($action == "modify") {
                $process->modifyService($id);
            }
        } else {
            header('Location: /connection');
        }
    }
}
