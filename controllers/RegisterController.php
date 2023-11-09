<?php
class RegisterController
{
    public function processRegister()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $email = $_POST["email"];
            $password = $_POST["password"];
        
            // Perform validation and authentication (you may check against a database)
            require_once '/models/connectionBDD.php';

            // Create an instance of the Database class
            $database = new Database();
            
            // Get the database connection
            $conn = $database->getConnection();
            
            // Now you can use $conn to execute SQL queries
            $sql = "INSERT INTO User (name) VALUES ('$email')";
            $conn->query($sql);
            echo "Register OK! <br>";
            // For this example, let's just display the submitted data
            echo "Email: $email <br>";
            echo "Password: $password <br>";
        } else {
            // If the form is not submitted via POST, you can add any additional logic here
        }
    }
}
