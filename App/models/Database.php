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
                echo "tables non existentes";
                $sql = "CREATE TABLE User (userID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), surname VARCHAR(255), mail VARCHAR(255) NOT NULL, pwd VARCHAR(255) NOT NULL, phoneNbr INT, isAdmin BOOL NOT NULL DEFAULT false, UNIQUE(mail));
                CREATE TABLE Annonce (annonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, title VARCHAR(255) NOT NULL, image VARCHAR(255), city VARCHAR(255) NOT NULL, price INT NOT NULL, typeLogement VARCHAR(255) NOT NULL);
                CREATE TABLE Reservation (reservationID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT NOT NULL, annonceID INT NOT NULL, dateDebut DATE NOT NULL, dateFin DATE NOT NULL, hasReviewed BOOLEAN DEFAULT FALSE NOT NULL, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                CREATE TABLE Review (reviewID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT NOT NULL, annonceID INT NOT NULL, grade INT NOT NULL, date DATE NOT NULL, comment VARCHAR(255) NOT NULL, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID), UNIQUE (userID, annonceID, date));
                CREATE TABLE Favorite (favoriteID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT NOT NULL, annonceID INT NOT NULL, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID), UNIQUE (userID, annonceID));
                CREATE TABLE TypeLogement (typeLogementID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL);
                CREATE TABLE Equipement (equipementID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL);
                CREATE TABLE EquipementAnnonce (equipementAnnonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, equipementID INT NOT NULL, annonceID INT NOT NULL, FOREIGN KEY (equipementID) REFERENCES Equipement(equipementID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));
                CREATE TABLE Service (serviceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL);
                CREATE TABLE ServiceAnnonce (serviceAnnonceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, serviceID INT NOT NULL, annonceID INT NOT NULL, FOREIGN KEY (serviceID) REFERENCES Service(serviceID), FOREIGN KEY (annonceID) REFERENCES Annonce(annonceID));";
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
            $queryService = "SELECT COUNT(*) as count FROM Service";
            $resultService = $this->conn->query($queryService);
            $countService = $resultService->fetch(PDO::FETCH_ASSOC)['count'];

            if ($countService == 0) {
                $sql = "INSERT INTO Service (name) VALUES ('Transferts aeroport'),('Petit-dejeuner'),('Service de menage'),('Location de voiture'),('Visites guidees'),('Cours de cuisine'),('Loisirs');
                        INSERT INTO Equipement (name) VALUES ('Connexion Wi-Fi'),('Climatiseur'),('Chauffage'),('Machine a laver'),('Seche-linge'),('Television'),('Fer a repasser / Planche a repasser'),('Nintendo Switch'),('PS5'),('Terrasse'),('Balcon'),('Piscine'),('Jardin');
                        INSERT INTO TypeLogement (name) VALUES ('Appartement'),('Maison'),('Chalet'),('Villa'),('Péniche'),('Yourte'),('Cabane'),('Igloo'),('Tente'),('Car');";
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

    //Remplir les tables ServiceAnnonce et EquipementAnnonce

    public function remplirEquipemmentAnnonceEtServiceAnnonce()
    {
        $sql = "SELECT AnnonceID FROM Annonce";
        $result = $this->conn->query($sql);

        if ($result !== false) {
            $annonceIDs = $result->fetchAll(PDO::FETCH_COLUMN);

            foreach ($annonceIDs as $annonceID) {
                $numEquipments = rand(1, 3);
                $numServices = rand(1, 3);

                $usedEquipments = [];
                $usedServices = [];

                for ($i = 0; $i < $numEquipments; $i++) {
                    $equipementID = $this->getUniqueRandomID($usedEquipments, 1, 13);
                    $rqtEquipement = $this->conn->prepare("INSERT INTO EquipementAnnonce(EquipementID, AnnonceID) VALUES (?, ?);");
                    $rqtEquipement->execute([$equipementID, $annonceID]);
                    $usedEquipments[] = $equipementID;
                }

                for ($i = 0; $i < $numServices; $i++) {
                    $serviceID = $this->getUniqueRandomID($usedServices, 1, 7);
                    $rqtService = $this->conn->prepare("INSERT INTO ServiceAnnonce(ServiceID, AnnonceID) VALUES (?, ?);");
                    $rqtService->execute([$serviceID, $annonceID]);
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

            $stmt = $this->conn->prepare("INSERT INTO Annonce (city, price, typeLogement, title, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$city, $price, $typeLogement, $title, $imageURL]);
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

    // Récupérer les services d'une annonce avec leur nom
    public function getServiceFromAnnonce($annonceID)
    {
        $sql = "SELECT s.* FROM Service s
            JOIN ServiceAnnonce sa ON s.serviceID = sa.serviceID
            WHERE sa.annonceID = :annonceID";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les équipements d'une annonce avec leur nom
    public function getEquipementFromAnnonce($annonceID)
    {
        $sql = "SELECT e.* FROM Equipement e
            JOIN EquipementAnnonce ea ON e.equipementID = ea.equipementID
            WHERE ea.annonceID = :annonceID";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
