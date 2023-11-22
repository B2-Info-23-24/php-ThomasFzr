<?php
class EditInfoUserController
{
    public function processEditInfoUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once __DIR__ . '/../models/Database.php';
            $database = new Database();
            $successMsg = "";

            if (isset($_POST["name"]) && $_POST["name"] != '') {
                $database->updateTable("User", "name", $_POST["name"], $_SESSION["mail"]);
                $successMsg = "Nom";
            }
            if (isset($_POST["surname"]) && $_POST["surname"] != '') {
                $database->updateTable("User", "surname", $_POST["surname"], $_SESSION["mail"]);
                $successMsg = $successMsg . " Prénom";
                $_SESSION['surname'] = $_POST["surname"];
            }
            if (isset($_POST["phoneNbr"]) && $_POST["phoneNbr"] != '') {
                $database->updateTable("User", "phoneNbr", $_POST["phoneNbr"], $_SESSION["mail"]);
                $successMsg = $successMsg . " Numéro de téléphone";
            }
            $_SESSION['successMsg'] = $successMsg . " changé avec succès";
            header('Location: /detailsCompte');
        } else {
            echo "erreur edit info user";
        }
    }
}
