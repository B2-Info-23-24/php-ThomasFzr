<?php
class LoginController
{
    public function processLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];
        
            require_once __DIR__ . '/../models/db_connect.php';
            $database = new Database();
            $database->authenticateUser($email, $password);
        } else {
        }
    }
}
?>