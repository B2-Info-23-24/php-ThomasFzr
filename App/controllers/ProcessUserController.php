<?php
class ProcessUserController
{
    private $db;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        $this->db = new Database();
    }

    public function addUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mail = $_POST["mail"];
            $pwd = $_POST["pwd"];
            $isAdmin = $_POST["isAdmin"];

            $name = null;
            $surname = null;
            $phoneNbr = null;

            if (isset($_POST["name"])) {
                $name = $_POST["name"];
            }
            if (isset($_POST["surname"])) {
                $surname = $_POST["surname"];
            }
            if (isset($_POST["phoneNbr"])) {
                $phoneNbr = $_POST["phoneNbr"];
            }

            if ($this->db->addUser($mail, $pwd, $isAdmin, $name, $surname, $phoneNbr)) {
                header('Location: /detailsUtilisateur');
            } else {
                header('Location: /detailsUtilisateur');
            }
        }
    }

    public function deleteUser($id)
    {

        if ($this->db->deleteUser($id)) {
            header("Location: /detailsUtilisateur");
        }
    }

    function processUser($action, $id)
    {
        if (isset($_SESSION['isAdmin'])) {
            $process = new ProcessUserController();
            if ($action == "add") {
                $process->addUser();
            } elseif ($action == "delete") {
                $process->deleteUser($id);
            }
        } else {
            header('Location: /connection');
        }
    }
}
