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


    //===== Call once in the script =====

    //Create all the tables
    public function createTables()
    {
        try {
            $sql = "SHOW TABLES LIKE 'User'";
            $result = $this->conn->query($sql);
            if ($result->rowCount() == 0) {
                $sql = "CREATE TABLE User (userID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), surname VARCHAR(255), mail VARCHAR(255) NOT NULL, pwd VARCHAR(255) NOT NULL, phoneNbr VARCHAR(255), isAdmin BOOL NOT NULL DEFAULT false, UNIQUE(mail));
                CREATE TABLE Accommodation (accommodationID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, title VARCHAR(255) NOT NULL, image VARCHAR(255), city VARCHAR(255) NOT NULL, price INT NOT NULL, accommodationType VARCHAR(255) NOT NULL);
                CREATE TABLE Reservation (reservationID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT NOT NULL, accommodationID INT NOT NULL, totalPrice INT NOT NULL,startDate DATE NOT NULL, endDate DATE NOT NULL, hasReviewed BOOLEAN DEFAULT FALSE NOT NULL, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (accommodationID) REFERENCES Accommodation(accommodationID));
                CREATE TABLE Review (reviewID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT NOT NULL, accommodationID INT NOT NULL, grade INT NOT NULL, date DATE NOT NULL, comment VARCHAR(255) NOT NULL, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (accommodationID) REFERENCES Accommodation(accommodationID), UNIQUE (userID, accommodationID, date));
                CREATE TABLE Favorite (favoriteID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, userID INT NOT NULL, accommodationID INT NOT NULL, FOREIGN KEY (userID) REFERENCES User(userID), FOREIGN KEY (accommodationID) REFERENCES Accommodation(accommodationID), UNIQUE (userID, accommodationID));
                CREATE TABLE AccommodationType (accommodationTypeID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL);
                CREATE TABLE Equipment (equipmentID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL);
                CREATE TABLE EquipmentAccommodation (equipmentAccommodationID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, equipmentID INT NOT NULL, accommodationID INT NOT NULL, FOREIGN KEY (equipmentID) REFERENCES Equipment(equipmentID), FOREIGN KEY (accommodationID) REFERENCES Accommodation(accommodationID), UNIQUE (equipmentID, accommodationID));
                CREATE TABLE Service (serviceID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL);
                CREATE TABLE ServiceAccommodation (serviceAccommodationID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, serviceID INT NOT NULL, accommodationID INT NOT NULL, FOREIGN KEY (serviceID) REFERENCES Service(serviceID), FOREIGN KEY (accommodationID) REFERENCES Accommodation(accommodationID), UNIQUE (serviceID, accommodationID));
                CREATE TABLE City (cityID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL);
                CREATE TABLE Image (imageID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL);";
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

    //Insert cities
    public function insertCity()
    {
        $sql = "INSERT INTO City (name) VALUES ('Nantes'),('Montpellier'),('Strasbourg'),('Angers'),('Lille'),('Rennes'),('Nice'),
                ('Lyon'),('Paris'),('Marseille'),('Toulouse'),('Lille'),('Rennes'),('Bordeaux');";
        if ($this->conn->exec($sql)) {
            return true;
        } else {
            return false;
        }
    }

    //Get cities
    public function getCity()
    {
        $rqt = "SELECT name FROM City";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Insert images
    public function insertImage()
    {
        $sql = "INSERT INTO Image (name) VALUES ('Appartement1.png'),('Appartement2.png'),('Appartement3.png'),('Cabane1.png'),('Cabane2.png'),('Cabane3.png'),('Car1.png'),
                ('Car2.png'),('Car3.png'),('Chalet1.png'),('Chalet2.png'),('Chalet3.png'),('Igloo1.png'),('Igloo2.png'),('Igloo3.png'),('Maison1.png'),('Maison2.png'),('Maison3.png'),
                ('Péniche1.png'),('Péniche2.png'),('Péniche3.png'),('Tente1.png'),('Tente2.png'),('Tente3.png'),('Villa1.png'),('Villa2.png'),('Villa3.png'),('Yourte1.png'),('Yourte2.png'),('Yourte3.png');";
        if ($this->conn->exec($sql)) {
            return true;
        } else {
            return false;
        }
    }

    //Get the images
    public function getImage()
    {
        $rqt = "SELECT name FROM Image";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Insert data in service, equipment, accommodation type
    public function insertDataAccommodationTypeEquipmentService()
    {
        try {
            $queryService = "SELECT COUNT(*) as count FROM Service";
            $resultService = $this->conn->query($queryService);
            $countService = $resultService->fetch(PDO::FETCH_ASSOC)['count'];

            if ($countService == 0) {
                $sql = "INSERT INTO Service (name) VALUES ('Transferts aeroport'),('Petit-dejeuner'),('Service de menage'),('Location de voiture'),('Visites guidees'),('Cours de cuisine'),('Loisirs');
                        INSERT INTO Equipment (name) VALUES ('Connexion Wi-Fi'),('Climatiseur'),('Chauffage'),('Machine a laver'),('Seche-linge'),('Television'),('Fer a repasser / Planche a repasser'),('Nintendo Switch'),('PS5'),('Terrasse'),('Balcon'),('Piscine'),('Jardin');
                        INSERT INTO AccommodationType (name) VALUES ('Appartement'),('Maison'),('Chalet'),('Villa'),('Péniche'),('Yourte'),('Cabane'),('Igloo'),('Tente'),('Car');";
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

    //Insert data in accomodationEquipment accommodationService

    public function insertDataAccommodationEquipmentAccommodationService()
    {
        $sql = "SELECT accommodationID FROM Accommodation";
        $result = $this->conn->query($sql);

        if ($result !== false) {
            $accommodationIDs = $result->fetchAll(PDO::FETCH_COLUMN);

            foreach ($accommodationIDs as $accommodationID) {
                $numEquipments = rand(1, 3);
                $numServices = rand(1, 3);

                $usedEquipments = [];
                $usedServices = [];

                for ($i = 0; $i < $numEquipments; $i++) {
                    $equipmentID = $this->getUniqueRandomID($usedEquipments, 1, 13);
                    $rqtEquipment = $this->conn->prepare("INSERT INTO EquipmentAccommodation(equipmentID, accommodationID) VALUES (?, ?);");
                    $rqtEquipment->execute([$equipmentID, $accommodationID]);
                    $usedEquipments[] = $equipmentID;
                }

                for ($i = 0; $i < $numServices; $i++) {
                    $serviceID = $this->getUniqueRandomID($usedServices, 1, 7);
                    $rqtService = $this->conn->prepare("INSERT INTO ServiceAccommodation(serviceID, accommodationID) VALUES (?, ?);");
                    $rqtService->execute([$serviceID, $accommodationID]);
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

    //Insert data with faker
    public function insertFakerDatas()
    {
        $homeNames = [' calme', ' lumineux', ' spacieuse', ' moderne', ' rustique', ' industriel', ' de campagne', ' élégant', ' contemporain', ' charmant', ' en bord de mer', ' accueillante', ' majestueux', ' paisible', ' pittoresque', ' confortable', ' de luxe', ' chaleureuse', ' montagnard'];

        $sql = "SELECT name FROM AccommodationType";
        $result = $this->conn->query($sql);
        $typesLogements = $result->fetchAll(PDO::FETCH_COLUMN);

        $sql = "SELECT name FROM City";
        $result = $this->conn->query($sql);
        $cities = $result->fetchAll(PDO::FETCH_COLUMN);

        for ($i = 0; $i < 50; $i++) {
            $city = $this->faker->randomElement($cities);
            $price = $this->faker->numberBetween(100, 1000);
            $typeLogement = $this->faker->randomElement($typesLogements);
            $title = $typeLogement . $this->faker->randomElement($homeNames);
            $imageURL = $typeLogement . $this->faker->numberBetween(1, 3) . ".png";

            $stmt = $this->conn->prepare("INSERT INTO Accommodation (city, price, accommodationType, title, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$city, $price, $typeLogement, $title, $imageURL]);
        }
    }

    public function createAccounts()
    {
        $hash1 = password_hash('admin', PASSWORD_DEFAULT);
        $hash2 = password_hash('elise', PASSWORD_DEFAULT);
        $hash3 = password_hash('bruce', PASSWORD_DEFAULT);
        $hash4 = password_hash('joe', PASSWORD_DEFAULT);
        $hash5 = password_hash('paul', PASSWORD_DEFAULT);
        $hash6 = password_hash('louis', PASSWORD_DEFAULT);

        $rqt = "INSERT INTO User (mail, pwd, surname, isAdmin) VALUES ('admin@admin.com', :pwd1, 'Admin', 1);
                INSERT INTO User (mail, pwd, surname, isAdmin) VALUES ('elise@elise.com', :pwd2, 'Elise', 0);
                INSERT INTO User (mail, pwd, surname, isAdmin) VALUES ('bruce@bruce.com', :pwd3, 'Bruce', 0);
                INSERT INTO User (mail, pwd, surname, isAdmin) VALUES ('joe@joe.com', :pwd4, 'Joe', 0);
                INSERT INTO User (mail, pwd, surname, isAdmin) VALUES ('paul@paul.com', :pwd5, 'Paul', 0);
                INSERT INTO User (mail, pwd, surname, isAdmin) VALUES ('louis@louis.com', :pwd6, 'Louis', 0);";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':pwd1', $hash1, PDO::PARAM_STR);
        $stmt->bindParam(':pwd2', $hash2, PDO::PARAM_STR);
        $stmt->bindParam(':pwd3', $hash3, PDO::PARAM_STR);
        $stmt->bindParam(':pwd4', $hash4, PDO::PARAM_STR);
        $stmt->bindParam(':pwd5', $hash5, PDO::PARAM_STR);
        $stmt->bindParam(':pwd6', $hash6, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function createFavorite()
    {
        $rqt = "INSERT INTO Favorite (userID, accommodationID) VALUES (2, 2);
                INSERT INTO Favorite (userID, accommodationID) VALUES (2, 8);
                INSERT INTO Favorite (userID, accommodationID) VALUES (3, 5);
                INSERT INTO Favorite (userID, accommodationID) VALUES (3, 1);
                INSERT INTO Favorite (userID, accommodationID) VALUES (3, 3);
                INSERT INTO Favorite (userID, accommodationID) VALUES (4, 1);
                INSERT INTO Favorite (userID, accommodationID) VALUES (5, 9);
                INSERT INTO Favorite (userID, accommodationID) VALUES (6, 10);
                INSERT INTO Favorite (userID, accommodationID) VALUES (6, 11);";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
    }

    public function createReservation()
    {
        $rqt1 = $this->conn->query("SELECT price FROM Accommodation WHERE accommodationID = 1;");
        $price1 = $rqt1->fetchColumn();
        $rqt2 = $this->conn->query("SELECT price FROM Accommodation WHERE accommodationID = 2;");
        $price2 = $rqt2->fetchColumn();
        $rqt3 = $this->conn->query("SELECT price FROM Accommodation WHERE accommodationID = 3;");
        $price3 = $rqt3->fetchColumn();
        $rqt4 = $this->conn->query("SELECT price FROM Accommodation WHERE accommodationID = 4;");
        $price4 = $rqt4->fetchColumn();
        $rqt5 = $this->conn->query("SELECT price FROM Accommodation WHERE accommodationID = 5;");
        $price5 = $rqt5->fetchColumn();
        $rqt6 = $this->conn->query("SELECT price FROM Accommodation WHERE accommodationID = 6;");
        $price6 = $rqt6->fetchColumn();
        $rqt11 = $this->conn->query("SELECT price FROM Accommodation WHERE accommodationID = 11;");
        $price11 = $rqt11->fetchColumn();

        $rqt = "INSERT INTO Reservation (userID, accommodationID, totalPrice, startDate, endDate, hasReviewed) VALUES (2, 1, '$price1', '2022-12-10', '2022-12-11', 1);
                INSERT INTO Reservation (userID, accommodationID, totalPrice, startDate, endDate, hasReviewed) VALUES (2, 2, '$price2', '2023-10-11', '2023-10-12', 0);
                INSERT INTO Reservation (userID, accommodationID, totalPrice, startDate, endDate, hasReviewed) VALUES (3, 3, '$price3', '2022-10-10', '2022-10-11', 1);
                INSERT INTO Reservation (userID, accommodationID, totalPrice, startDate, endDate, hasReviewed) VALUES (4, 4, '$price4', '2023-05-24', '2023-05-25', 1);
                INSERT INTO Reservation (userID, accommodationID, totalPrice, startDate, endDate, hasReviewed) VALUES (4, 5, '$price5', '2021-05-20', '2021-05-21', 1);
                INSERT INTO Reservation (userID, accommodationID, totalPrice, startDate, endDate, hasReviewed) VALUES (4, 6, '$price6', '2023-07-01', '2023-07-02', 0);
                INSERT INTO Reservation (userID, accommodationID, totalPrice, startDate, endDate, hasReviewed) VALUES (5, 11, '$price11', '2023-12-21', '2023-12-22', 0);
                INSERT INTO Reservation (userID, accommodationID, totalPrice, startDate, endDate, hasReviewed) VALUES (6, 3, '$price3', '2023-11-12', '2023-11-13', 1);";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
    }

    public function createReview()
    {
        $rqt = "INSERT INTO Review (userID, accommodationID, grade, date, comment) VALUES (2, 1, 4, '2022-12-14', 'Vraiment agréable, conforme à la description! Je reviendrai :D');
                INSERT INTO Review (userID, accommodationID, grade, date, comment) VALUES (3, 3, 2, '2022-10-12', 'Moyen, les voisins étaient bruyant, le frigo fuyait et il faisait trop chaud.');
                INSERT INTO Review (userID, accommodationID, grade, date, comment) VALUES (4, 4, 5, '2023-05-27', 'Très calme, paysage magnifique, très bien équipée!');
                INSERT INTO Review (userID, accommodationID, grade, date, comment) VALUES (4, 5, 3, '2021-05-25', 'Génial, rien à dire, c\'était juste super, l\'année prochaine je serai le premier à réserver!!!');
                INSERT INTO Review (userID, accommodationID, grade, date, comment) VALUES (6, 3, 4, '2023-11-14', 'Plutôt moyen, les jeunes du quartier font du bruit toute la nuit...');";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
    }

    //===== GENERAL =====

    //Update a table
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
