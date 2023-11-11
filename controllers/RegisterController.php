<?php
class RegisterController
{
    public function processRegister()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            require_once __DIR__ . '/../models/db_connect.php';

            $database = new Database();
            
            $conn = $database->getConnection();
            
            $sql = "INSERT INTO User (name) VALUES ('$email')";
            $conn->query($sql);
            echo "Register OK! <br>";
            echo "Email: $email <br>";
            echo "Password: $password <br>";
        } else {
        }
    }
}
