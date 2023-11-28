<?php
class Connection
{

    private $conn;
    private $user;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        require_once __DIR__ . '/../models/User.php';
        $db = new Database();
        $this->conn = $db->conn;
        $this->user = new User();

    }

    //Authentification de connexion et récupération données user
    public function authenticateUser($mail, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM User WHERE mail = :mail");
            $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (is_array($row)) {
                if (password_verify($password, $row['pwd'])) {
                    $_SESSION['isConnected'] = true;
                    $_SESSION['mail'] = $mail;
                    $db = new Database();
                    $_SESSION['userID'] = $this->user->getUserInfo($mail)['userID'];
                    $_SESSION['surname'] = $this->user->getUserInfo($mail)['surname'];
                    $_SESSION['isAdmin'] = $this->user->getUserInfo($mail)['isAdmin'];
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}