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

    public function modifyUser($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $successMsg = "";

            if (isset($_POST["mail"]) && $_POST["mail"] != '') {
                $this->db->modifyUser("mail", $_POST["mail"], $id);
                $successMsg = $successMsg . " Mail";
            }
            if (isset($_POST["pwd"]) && $_POST["pwd"] != '') {
                $hash = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
                $this->db->modifyUser("pwd", $hash, $id);
                $successMsg = $successMsg . " MDP";
            }
            if (isset($_POST["name"]) && $_POST["name"] != '') {
                $this->db->modifyUser("name", $_POST["name"], $id);
                $successMsg = "Nom";
            }
            if (isset($_POST["surname"]) && $_POST["surname"] != '') {
                $this->db->modifyUser("surname", $_POST["surname"], $id);
                $successMsg = $successMsg . " Prénom";
            }
            if (isset($_POST["phoneNbr"]) && $_POST["phoneNbr"] != '') {
                $this->db->modifyUser("phoneNbr", $_POST["phoneNbr"], $id);
                $successMsg = $successMsg . " Numéro de téléphone";
            }
            if (isset($_POST["isAdmin"]) && $_POST["isAdmin"] != '') {
                $this->db->modifyUser("isAdmin", $_POST["isAdmin"], $id);
                $successMsg = $successMsg . " isAdmin";
            }

            if ((isset($_POST["name"]) && $_POST["name"] != '') || (isset($_POST["surname"]) && $_POST["surname"] != '')
                || (isset($_POST["phoneNbr"]) && $_POST["phoneNbr"] != '') || (isset($_POST["mail"]) && $_POST["mail"] != '')
                || (isset($_POST["mail"]) && $_POST["mail"] != '') || (isset($_POST["isAdmin"]) && $_POST["isAdmin"] != '')
            ) {
                $_SESSION['successMsg'] = $successMsg . " changé avec succès";
            }

            header('Location: /detailsUtilisateur');
        } else {
            echo "erreur edit info user";
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
            } elseif ($action == "modify") {
                $process->modifyUser($id);
            }
        } else {
            header('Location: /connection');
        }
    }
}
