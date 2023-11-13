<?php
class LoginController
{
    public function processLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];
        
            echo "Login OK! <br>";
            echo "Email: $email <br>";
            echo "Password: $password <br>";
        } else {
        }
    }
}
?>