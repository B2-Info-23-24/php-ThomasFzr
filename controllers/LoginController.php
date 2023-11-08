<?php
class LoginController
{
    public function processLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $email = $_POST["email"];
            $password = $_POST["password"];
        
            // Perform validation and authentication (you may check against a database)
        
            echo "Login OK! <br>";
            // For this example, let's just display the submitted data
            echo "Email: $email <br>";
            echo "Password: $password <br>";
        } else {
            // If the form is not submitted via POST, you can add any additional logic here
        }
    }
}
?>