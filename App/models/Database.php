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
    public $conn;
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
                $sql = "CREATE TABLE User (userID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), surname VARCHAR(255), mail VARCHAR(255) NOT NULL, pwd VARCHAR(255) NOT NULL, phoneNbr INT, isAdmin BOOL NOT NULL DEFAULT false, UNIQUE(mail));
                CREATE TABLE Accomodation (accomodationID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, title VARCHAR(255) NOT NULL, image VARCHAR(255), city VARCHAR(255) NOT NULL, price INT NOT NULL, accomodationType VARCHAR(255) NOT NULL);
                CREATE TABLE Reservation (reservationID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT NOT NULL, accomodationID INT NOT NULL, totalPrice INT NOT NULL,startDate DATE NOT NULL, endDate DATE NOT NULL, hasReviewed BOOLEAN DEFAULT FALSE NOT NULL, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (accomodationID) REFERENCES Accomodation(accomodationID));
                CREATE TABLE Review (reviewID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT NOT NULL, accomodationID INT NOT NULL, grade INT NOT NULL, date DATE NOT NULL, comment VARCHAR(255) NOT NULL, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (accomodationID) REFERENCES Accomodation(accomodationID), UNIQUE (userID, accomodationID, date));
                CREATE TABLE Favorite (favoriteID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT NOT NULL, accomodationID INT NOT NULL, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (accomodationID) REFERENCES Accomodation(accomodationID), UNIQUE (userID, accomodationID));
                CREATE TABLE AccomodationType (accomodationTypeID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL);
                CREATE TABLE Equipment (equipmentID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL);
                CREATE TABLE EquipmentAccomodation (equipmentAccomodationID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, equipmentID INT NOT NULL, accomodationID INT NOT NULL, FOREIGN KEY (equipmentID) REFERENCES Equipment(equipmentID), FOREIGN KEY (accomodationID) REFERENCES Accomodation(accomodationID));
                CREATE TABLE Service (serviceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL);
                CREATE TABLE ServiceAccomodation (serviceAccomodationID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, serviceID INT NOT NULL, accomodationID INT NOT NULL, FOREIGN KEY (serviceID) REFERENCES Service(serviceID), FOREIGN KEY (accomodationID) REFERENCES Accomodation(accomodationID));";
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
    public function insertDataAccomodationTypeEquipmentService()
    {
        try {
            $queryService = "SELECT COUNT(*) as count FROM Service";
            $resultService = $this->conn->query($queryService);
            $countService = $resultService->fetch(PDO::FETCH_ASSOC)['count'];

            if ($countService == 0) {
                $sql = "INSERT INTO Service (name) VALUES ('Transferts aeroport'),('Petit-dejeuner'),('Service de menage'),('Location de voiture'),('Visites guidees'),('Cours de cuisine'),('Loisirs');
                        INSERT INTO Equipment (name) VALUES ('Connexion Wi-Fi'),('Climatiseur'),('Chauffage'),('Machine a laver'),('Seche-linge'),('Television'),('Fer a repasser / Planche a repasser'),('Nintendo Switch'),('PS5'),('Terrasse'),('Balcon'),('Piscine'),('Jardin');
                        INSERT INTO AccomodationType (name) VALUES ('Appartement'),('Maison'),('Chalet'),('Villa'),('Péniche'),('Yourte'),('Cabane'),('Igloo'),('Tente'),('Car');";
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

    //Remplir les tables ServiceAccomodation et EquipmentAccomodation

    public function insertDataAccomodationEquipmentAccomodationService()
    {
        $sql = "SELECT accomodationID FROM Accomodation";
        $result = $this->conn->query($sql);

        if ($result !== false) {
            $accomodationIDs = $result->fetchAll(PDO::FETCH_COLUMN);

            foreach ($accomodationIDs as $accomodationID) {
                $numEquipments = rand(1, 3);
                $numServices = rand(1, 3);

                $usedEquipments = [];
                $usedServices = [];

                for ($i = 0; $i < $numEquipments; $i++) {
                    $equipmentID = $this->getUniqueRandomID($usedEquipments, 1, 13);
                    $rqtEquipment = $this->conn->prepare("INSERT INTO EquipmentAccomodation(equipmentID, accomodationID) VALUES (?, ?);");
                    $rqtEquipment->execute([$equipmentID, $accomodationID]);
                    $usedEquipments[] = $equipmentID;
                }

                for ($i = 0; $i < $numServices; $i++) {
                    $serviceID = $this->getUniqueRandomID($usedServices, 1, 7);
                    $rqtService = $this->conn->prepare("INSERT INTO ServiceAccomodation(ServiceID, accomodationID) VALUES (?, ?);");
                    $rqtService->execute([$serviceID, $accomodationID]);
                    $usedServices[] = $serviceID;
                }
            }
        }
    }

    private function getUniqueRandomID($usedIDs, $min, $max)
    {
        do {
            $randomID = rand($min, $max);
        } while (in_array($randomID, $usedIDs));

        return $randomID;
    }


    //===== FAKER =====

    //Remplir les tables avec les données de Faker
    public function insertFakerDatas()
    {
        $homeNames = [' calme', ' lumineux', ' spacieuse', ' moderne', ' rustique', ' industriel', ' de campagne', ' élégant', ' contemporain', ' charmant', ' en bord de mer', ' accueillante', ' majestueux', ' paisible', ' pittoresque', ' confortable', ' de luxe', ' chaleureuse', ' montagnard'];
        $typesLogements = ['Appartement', 'Maison', 'Chalet', 'Villa', 'Péniche', 'Yourte', 'Cabane', 'Igloo', 'Tente', 'Car'];
        $cities = ['Lyon', 'Paris', 'Marseille', 'Grenoble', 'Toulouse', 'Bordeaux', 'Limoge', 'Perpignan', 'Nice', 'Nantes', 'Montpellier', 'Strasbourg', 'Angers', 'Lille', 'Rennes', 'Caen'];
        for ($i = 0; $i < 50; $i++) {
            $city = $this->faker->randomElement($cities);
            $price = $this->faker->numberBetween(100, 1000);
            $typeLogement = $this->faker->randomElement($typesLogements);
            $title = $typeLogement . $this->faker->randomElement($homeNames);
            $imageURL = $typeLogement . $this->faker->numberBetween(1, 3) . ".png";

            $stmt = $this->conn->prepare("INSERT INTO Accomodation (city, price, typeLogement, title, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$city, $price, $typeLogement, $title, $imageURL]);
        }
    }

    public function createAccounts()
    {
        $hash1 = password_hash('user', PASSWORD_DEFAULT);
        $hash2 = password_hash('admin', PASSWORD_DEFAULT);

        $rqt = "INSERT INTO User (mail, pwd, surname, isAdmin) VALUES ('user@user.com', :pwd1, 'User', 0);
                INSERT INTO User (mail, pwd, surname, isAdmin) VALUES ('admin@admin.com', :pwd2, 'Admin', 1);";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':pwd1', $hash1, PDO::PARAM_STR);
        $stmt->bindParam(':pwd2', $hash2, PDO::PARAM_STR);
        $stmt->execute();
    }

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
}
