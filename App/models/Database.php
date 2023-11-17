<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Faker\Factory;

require_once 'vendor/autoload.php';

class Database
{
    private $host = 'mysql';
    private $dbname = 'my_database';
    private $username = 'my_user';
    private $password = 'my_password';
    private $conn;
    private $faker;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Connection failed (func construct): " . $e->getMessage());
        }

        $this->faker = Factory::create('fr_FR');
    }

    public function getConnection()
    {
        try {
            return $this->conn;
        } catch (PDOException $e) {
            die("Connection failed (func getConnection): " . $e->getMessage());
        }
    }


    public function getTable()
    {
        try {
            $data = $this->conn->query("SELECT * FROM User")->fetchAll();
            foreach ($data as $row) {
                echo $row['nom'] . "<br />\n";
            }
            echo 'Succès !';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    //Appeler une seule fois au premier chargement de la page
    public function createTables()
    {
        try {
            $sql = "CREATE TABLE User (userID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), surname VARCHAR(255), mail VARCHAR(255), pwd VARCHAR(255), phoneNbr INT, favoriteID INT, commentGradeID INT, reservationID INT, isAdmin BOOL);
                    CREATE TABLE Annonce (annonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, dateDispo DATE,  name VARCHAR(255), image VARCHAR(255), adresse VARCHAR(255), price INT, typeLogementAnnonceID INT, equipementAnnonceID INT, serviceAnnonceID INT, commentGradeID INT, reservationID INT, favoriteID INT);
                    CREATE TABLE Reservation (reservationID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT, annonceID INT, dateDebut DATE, dateFin DATE, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                    CREATE TABLE CommentGrade (commentGradeID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT, annonceID INT, grade FLOAT, comment VARCHAR(255), FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                    CREATE TABLE Favorite (favoriteID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT, annonceID INT, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID), UNIQUE (userID, annonceID));
                    CREATE TABLE TypeLogement (typeLogementID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255));
                    CREATE TABLE TypeLogementAnnonce (typeLogementAnnonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, typeLogementID INT, annonceID INT, FOREIGN KEY (typeLogementID) REFERENCES TypeLogement(typeLogementID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                    CREATE TABLE Equipement (equipementID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255));
                    CREATE TABLE EquipementAnnonce (equipementAnnonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, equipementID INT, annonceID INT, FOREIGN KEY (equipementID) REFERENCES Equipement(equipementID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                    CREATE TABLE Service (serviceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255));
                    CREATE TABLE ServiceAnnonce (serviceAnnonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, serviceID INT, annonceID INT, FOREIGN KEY (serviceID) REFERENCES Service(serviceID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));";
            $this->conn->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    //Appeler une seule fois au premier chargement de la page
    public function remplirLogementEquipementService()
    {
        try {
            $sql = "INSERT INTO Service (name) VALUES ('Transferts aeroport'), ('Petit-dejeuner'), ('Service de menage'), ('Location de voiture'), ('Visites guidees'), ('Cours de cuisine'), ('Loisirs');
                    INSERT INTO TypeLogement (name) VALUES ('Appartements'), ('Maisons'), ('Chalets'), ('Villas'), ('Peniches'), ('Yourtes'), ('Cabanes'), ('Igloos'), ('Tentes'), ('Cars');
                    INSERT INTO Equipement (name) VALUES ('Connexion Wi-Fi'), ('Climatiseur'), ('Chauffage'), ('Machine a laver'), ('Seche-linge'), ('Television'), ('Fer a repasser / Planche a repasser'), ('Nintendo Switch'), ('PS5'), ('Terrasse'), ('Balcon'), ('Piscine'), ('Jardin');";
            $this->conn->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    function insertIntoTable($table, $column, $value)
    {
        try {
            $sql = "INSERT INTO $table ($column) VALUES ('$value')";
            $this->conn->exec($sql);
            echo 'Succès! <br>';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    function insertIntoTableRegister($mail, $pwd)
    {
        try {
            $sql = "INSERT INTO User (mail, pwd) VALUES ('$mail', '$pwd')";
            $this->conn->exec($sql);
            echo 'Succès! <br>';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function authenticateUser($email, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM User WHERE mail = :email AND pwd = :password");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['isConnected'] = true;
                $_SESSION['mail'] = $email;
                $db = new Database();
                $_SESSION['userID'] = $db->getUserInfo($email)['userID'];
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getUserInfo($email)
    {
        $rqt = "SELECT * FROM User WHERE mail = :email";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAnnonce()
    {
        $rqt = "SELECT * FROM Annonce";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetailsAnnonce($annonceID)
    {
        $rqt = "SELECT * FROM Annonce WHERE annonceID = :annonceID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getTypeLogement()
    {
        $rqt = "SELECT * FROM TypeLogement";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getService()
    {
        $rqt = "SELECT * FROM Service";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEquipement()
    {
        $rqt = "SELECT * FROM Equipement";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFavorite($userID)
    {
        $rqt = "SELECT Annonce.*
                FROM Annonce
                JOIN Favorite ON Annonce.annonceID = Favorite.annonceID
                JOIN User ON Favorite.userID = User.userID
                WHERE User.userID = :userID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function updateTable($table, $column, $value, $email)
    {
        $rqt = "UPDATE $table SET $column = :value WHERE mail = :email";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function insertFakerDatas()
    {

        $homeNames = [
            'Petite maison calme',
            'Appartement lumineux',
            'Villa spacieuse',
            'Studio moderne',
            'Chalet rustique',
            'Loft industriel',
            'Maison de campagne',
            'Penthouse élégant'
        ];

        for ($i = 0; $i < 10; $i++) {
            $dateDispo = $this->faker->date;
            $adresse = $this->faker->address;
            $price = $this->faker->numberBetween(100, 1000);
            $typeLogementAnnonceID = $this->faker->numberBetween(1, 5);
            $equipementAnnonceID = $this->faker->numberBetween(1, 5);
            $serviceAnnonceID = $this->faker->numberBetween(1, 5);
            $commentGradeID = $this->faker->numberBetween(1, 5);
            $reservationID = $this->faker->numberBetween(1, 5);
            $favoriteID = $this->faker->numberBetween(1, 5);
            $name = $this->faker->randomElement($homeNames);
            $randomQueryParam = md5(uniqid());
            $imageURL = "https://source.unsplash.com/800x600/?home&$randomQueryParam";

            $stmt = $this->conn->prepare("INSERT INTO Annonce (dateDispo, adresse, price, typeLogementAnnonceID, equipementAnnonceID, serviceAnnonceID, commentGradeID, reservationID, favoriteID, name, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$dateDispo, $adresse, $price, $typeLogementAnnonceID, $equipementAnnonceID, $serviceAnnonceID, $commentGradeID, $reservationID, $favoriteID, $name, $imageURL]);
        }
    }
    public function addToFavorite($annonceID)
    {
        $userID = $_SESSION['userID'];

        $rqt = "INSERT INTO Favorite (userID, annonceID) VALUES (:userID, :annonceID)";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function isInFavorite($annonceID)
    {
        $userID = $_SESSION['userID'];

        $rqt = "SELECT Favorite.*
            FROM Favorite
            JOIN Annonce ON Annonce.annonceID = Favorite.annonceID
            JOIN User ON Favorite.userID = User.userID
            WHERE User.userID = :userID
              AND Annonce.annonceID = :annonceID";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    
}
