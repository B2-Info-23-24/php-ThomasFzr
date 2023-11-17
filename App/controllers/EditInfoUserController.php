<?php
class EditInfoUserController
{
    public function processEditInfoUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once __DIR__ . '/../models/Database.php';
            $database = new Database();

            if (isset($_POST["name"]) && $_POST["name"] != '') {
                $database->updateTable("User", "name", $_POST["name"], $_SESSION["mail"]);
                $database->getUserInfo($_SESSION["mail"]);
                echo "name changed";
            }
            if (isset($_POST["surname"]) && $_POST["surname"] != '') {
                $database->updateTable("User", "surname", $_POST["surname"], $_SESSION["mail"]);
                $database->getUserInfo($_SESSION["mail"]);
                echo "surname changed";
            }
            if (isset($_POST["phoneNbr"]) && $_POST["phoneNbr"] != '') {
                $database->updateTable("User", "phoneNbr", $_POST["phoneNbr"], $_SESSION["mail"]);
                $database->getUserInfo($_SESSION["mail"]);
                echo "phoneNbr changed";
            }
        } else {
            echo "erreur edit info user";
        }
    }
}
