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


    //===== Appeler une seule fois au premier chargement de la page =====

    //Creation de toutes les tables
    public function createTables()
    {
        try {
            $sql = "SHOW TABLES LIKE 'User'";
            $result = $this->conn->query($sql);
            if ($result->rowCount() == 0) {
                $sql = "CREATE TABLE User (userID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), surname VARCHAR(255), mail VARCHAR(255), pwd VARCHAR(255), phoneNbr INT, favoriteID INT, commentGradeID INT, reservationID INT, isAdmin BOOL);
                    CREATE TABLE Annonce (annonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), image VARCHAR(255), ville VARCHAR(255), price INT, typeLogement VARCHAR(255), commentGradeID INT, reservationID INT, favoriteID INT);
                    CREATE TABLE Reservation (reservationID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT, annonceID INT, dateDebut DATE, dateFin DATE, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                    CREATE TABLE CommentGrade (commentGradeID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT, annonceID INT, grade FLOAT, date DATE, comment VARCHAR(255), FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID), UNIQUE (userID, annonceID, date));
                    CREATE TABLE Favorite (favoriteID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT, annonceID INT, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID), UNIQUE (userID, annonceID));
                    CREATE TABLE TypeLogement (typeLogementID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255));
                    CREATE TABLE Equipement (equipementID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255));
                    CREATE TABLE EquipementAnnonce (equipementAnnonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, equipementID INT, annonceID INT, FOREIGN KEY (equipementID) REFERENCES Equipement(equipementID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                    CREATE TABLE Service (serviceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255));
                    CREATE TABLE ServiceAnnonce (serviceAnnonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, serviceID INT, annonceID INT, FOREIGN KEY (serviceID) REFERENCES Service(serviceID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));";
                $this->conn->exec($sql);
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    //Remplir les tables de services type de logement et equipements
    public function remplirLogementEquipementService()
    {
        try {
            // Vérifier si la table Service est vide
            $queryService = "SELECT COUNT(*) as count FROM Service";
            $resultService = $this->conn->query($queryService);
            $countService = $resultService->fetch(PDO::FETCH_ASSOC)['count'];

            // Vérifier si la table Equipement est vide
            $queryEquipement = "SELECT COUNT(*) as count FROM Equipement";
            $resultEquipement = $this->conn->query($queryEquipement);
            $countEquipement = $resultEquipement->fetch(PDO::FETCH_ASSOC)['count'];

            // Vérifier si la table TypeLogement est vide
            $queryTypeLogement = "SELECT COUNT(*) as count FROM TypeLogement";
            $resultTypeLogement = $this->conn->query($queryTypeLogement);
            $countTypeLogement = $resultTypeLogement->fetch(PDO::FETCH_ASSOC)['count'];

            // Si les tables ne sont pas encore remplies, on peut les remplir
            if ($countService == 0 && $countEquipement == 0 && $countTypeLogement == 0) {
                $sql = "INSERT INTO Service (name) VALUES ('Transferts aeroport'),('Petit-dejeuner'),('Service de menage'),('Location de voiture'),('Visites guidees'),('Cours de cuisine'),('Loisirs');
                        INSERT INTO Equipement (name) VALUES ('Connexion Wi-Fi'),('Climatiseur'),('Chauffage'),('Machine a laver'),('Seche-linge'),('Television'),('Fer a repasser / Planche a repasser'),('Nintendo Switch'),('PS5'),('Terrasse'),('Balcon'),('Piscine'),('Jardin');
                        INSERT INTO TypeLogement (name) VALUES ('Appartements'),('Maisons'),('Chalets'),('Villas'),('Péniches'),('Yourtes'),('Cabanes'),('Igloos'),('Tentes'),('Cars');";
                $this->conn->exec($sql);
                return true;
            } else {
                return false; // Les tables sont déjà remplies
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }



    //===== =================================== =====

    //===== SERVICES TYPES LOGEMENT EQUIPEMENTS =====

    //Récupérer les types de logement
    public function getTypeLogement()
    {
        $rqt = "SELECT * FROM TypeLogement";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Récupérer les services
    public function getService()
    {
        $rqt = "SELECT * FROM Service";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Récupérer les équipements
    public function getEquipement()
    {
        $rqt = "SELECT * FROM Equipement";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //===== =================================== =====


    //===== CONNEXION/INSCRIPTION DONNEES USER =====

    //Insert inscription et récupération données user
    function insertIntoTableRegister($mail, $pwd)
    {
        try {
            $sql = "INSERT INTO User (mail, pwd) VALUES ('$mail', '$pwd')";
            $this->conn->exec($sql);
            $_SESSION['isConnected'] = true;
            $_SESSION['mail'] = $mail;
            $db = new Database();
            $_SESSION['userID'] = $db->getUserInfo($mail)['userID'];
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    //Authentification de connexion et récupération données user
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

    //Récupération données user
    public function getUserInfo($email)
    {
        $rqt = "SELECT * FROM User WHERE mail = :email";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    //===== =================================== =====

    //===== ANNONCE =====

    //Récupérer toutes les annonces
    public function getAnnonce($requete)
    {
        $rqt = "SELECT * FROM Annonce $requete";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Récupérer détails d'une annonce
    public function getDetailsAnnonce($annonceID)
    {
        $rqt = "SELECT * FROM Annonce WHERE annonceID = :annonceID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //===== =================================== =====

    //===== GENERALES =====

    //Update d'une table
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

    //===== FAKER =====

    //Remplir les tables avec les données de Faker
    public function insertFakerDatas()
    {
        $homeNames = ['Petite maison calme', 'Appartement lumineux', 'Villa spacieuse', 'Studio moderne', 'Chalet rustique', 'Loft industriel', 'Maison de campagne', 'Penthouse élégant', 'Duplex contemporain', 'Manoir charmant', 'Cabane en bord de mer', 'Maisonnette accueillante', 'Château majestueux', 'Résidence paisible', 'Cottage pittoresque', 'Bungalow confortable', 'Appartement de luxe', 'Maisonnette chaleureuse', 'Refuge montagnard'];
        $typesLogements = ['Appartements', 'Maisons', 'Chalets', 'Villas', 'Peniches', 'Yourtes', 'Cabanes', 'Igloos', 'Tentes', 'Cars'];
        for ($i = 0; $i < 10; $i++) {
            $dateDispo = $this->faker->date;
            $ville = $this->faker->city;
            $price = $this->faker->numberBetween(100, 1000);
            $typeLogement = $this->faker->randomElement($typesLogements);
            $commentGradeID = $this->faker->numberBetween(1, 5);
            $reservationID = $this->faker->numberBetween(1, 5);
            $favoriteID = $this->faker->numberBetween(1, 5);
            $name = $this->faker->randomElement($homeNames);
            $randomQueryParam = md5(uniqid());
            $imageURL = "https://source.unsplash.com/800x600/?home&$randomQueryParam";

            $stmt = $this->conn->prepare("INSERT INTO Annonce (dateDispo, ville, price, typeLogement, commentGradeID, reservationID, favoriteID, name, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$dateDispo, $ville, $price, $typeLogement, $commentGradeID, $reservationID, $favoriteID, $name, $imageURL]);
        }
    }
    //===== =================================== =====

    //===== FAVORIS =====

    //Récupérer les annonces ajoutées en favoris par le user actuel
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

    //Ajouter en favoris une annonce
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

    //Retirer une annonce des favoris
    public function removeFromFavorite($annonceID)
    {
        $userID = $_SESSION['userID'];
        $rqt = "DELETE FROM Favorite WHERE userID = :userID AND annonceID = :annonceID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Tester si une annonce a été ajouté en favoris par le user actuel
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
    //===== =================================== =====

    //===== AVIS =====
    public function getCommentGradeFromUser()
    {
        $userID = $_SESSION['userID'];

        $rqt = "SELECT * FROM CommentGrade WHERE userID = :userID";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return false;
        }
    }

    public function getCommentGradeFromAnnonce($annonceID)
    {

        $rqt = "SELECT * FROM CommentGrade WHERE annonceID = :annonceID";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return false;
        }
    }

    public function insertAvis($annonceID, $grade, $comment, $date){
        $userID = $_SESSION['userID'];

        $rqt = "INSERT INTO CommentGrade (userID, annonceID, grade, comment, date) VALUES (:userID, :annonceID,:grade, :comment, :date)";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_STR);
        $stmt->bindParam(':grade', $grade, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

//===== =================================== =====

    //===== RESERVATION =====
    public function insertReservation($annonceID,  $dateDebut, $dateFin){
        $userID = $_SESSION['userID'];

        $rqt = "INSERT INTO Reservation (userID, annonceID, dateDebut, dateFin) VALUES (:userID, :annonceID,:dateDebut, :dateFin)";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_STR);
        $stmt->bindParam(':dateDebut', $dateDebut, PDO::PARAM_STR);
        $stmt->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
