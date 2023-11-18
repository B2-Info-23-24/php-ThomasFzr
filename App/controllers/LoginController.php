<?php
class LoginController
{
    public function processLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            require_once __DIR__ . '/../models/Database.php';
            $database = new Database();
            if ($database->authenticateUser($email, $password)) {
                $_SESSION['successMsg'] = "Connexion réussie!<br>";
                header('Location: /');
                exit;
            } else {
                $_SESSION['successMsg'] = "Mail ou mdp invalide";
                header('Location: /connection');
                exit;
            }
        } else {
        }
    }
}
