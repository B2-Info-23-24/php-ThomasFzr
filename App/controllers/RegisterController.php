<?php
class RegisterController
{
    public function processRegister()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            require_once __DIR__ . '/../models/DataBase.php';
            $database = new Database();
            $database->insertIntoTableRegister($email, $password);
            echo "Register ok! <br/>";
        } else {
        }
    }
}