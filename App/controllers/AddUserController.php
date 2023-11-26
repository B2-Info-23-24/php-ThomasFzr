<?php
class AddUserController
{
    public function addUser()
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Database.php';
            $db = new Database();

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

                if ($db->addUser($mail, $pwd, $isAdmin, $name, $surname, $phoneNbr)) {
                    header('Location: /detailsUtilisateur');
                } else {
                    header('Location: /detailsUtilisateur');
                }
            }
        } else {
            header('Location: /');
        }
    }
}
