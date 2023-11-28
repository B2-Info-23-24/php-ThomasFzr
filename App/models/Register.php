<?php
class Register
{

    private $conn;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        $this->conn = $db->conn;
    }

    //Insert inscription et récupération données user
    function insertIntoTableRegister($mail, $pwd)
    {
        $rqt = "SELECT * from User where mail = :mail";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $_SESSION['errorMsg'] = "Un compte existe déjà avec cette adresse mail.";
            return false;
        } else {
            $hash = password_hash($pwd, PASSWORD_DEFAULT);
            $sql = "INSERT INTO User (mail, pwd) VALUES ('$mail', '$hash')";
            $this->conn->exec($sql);
            $_SESSION['isConnected'] = true;
            $_SESSION['mail'] = $mail;
            $db = new Database();
            $_SESSION['userID'] = $db->getUserInfo($mail)['userID'];
            $_SESSION['successMsg'] = "Bienvenue!";
            return true;
        }
    }
}