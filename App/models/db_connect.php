<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


class Database
{
    private $host = 'mysql';
    private $dbname = 'my_database';
    private $username = 'my_user';
    private $password = 'my_password';
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            // $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Connection failed (func construct): " . $e->getMessage());
        }
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
                    CREATE TABLE Annonce (annonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, dateDispo DATE, adresse VARCHAR(255), price INT, typeLogementAnnonceID INT, equipementAnnonceID INT, serviceAnnonceID INT, commentGradeID INT, reservationID INT, favoriteID INT);
                    CREATE TABLE Reservation (reservationID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT, annonceID INT, dateDebut DATE, dateFin DATE, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                    CREATE TABLE CommentGrade (commentGradeID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT, annonceID INT, grade FLOAT, comment VARCHAR(255), FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                    CREATE TABLE Favorite (favoriteID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT, annonceID INT, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                    CREATE TABLE TypeLogement (typeLogementID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255));
                    CREATE TABLE TypeLogementAnnonce (typeLogementAnnonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, typeLogementID INT, annonceID INT, FOREIGN KEY (typeLogementID) REFERENCES TypeLogement(typeLogementID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                    CREATE TABLE Equipement (equipementID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255));
                    CREATE TABLE EquipementAnnonce (equipementAnnonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, equipementID INT, annonceID INT, FOREIGN KEY (equipementID) REFERENCES Equipement(equipementID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                    CREATE TABLE Service (serviceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255));
                    CREATE TABLE ServiceAnnonce (serviceAnnonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, serviceID INT, annonceID INT, FOREIGN KEY (serviceID) REFERENCES Service(serviceID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));";
            $this->conn->exec($sql);
            echo 'Table bien créée !';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
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
            echo 'Table bien créée !';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
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
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['isConnected'] = true;
                $_SESSION['mail'] = $email;
                $_SESSION['pwd'] = $password;
                echo "Connexion réussie!<br>";
                echo "Bonjour, $email!";
                include 'App/views/home.php';
            } else {
                echo "Mail ou mdp invalide";
                include 'App/views/connectionView.php';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }



}
