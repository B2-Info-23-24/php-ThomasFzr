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




    //===== =================================== =====


    //===== CONNEXION/INSCRIPTION DONNEES USER =====

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
                    $_SESSION['userID'] = $db->getUserInfo($mail)['userID'];
                    $_SESSION['surname'] = $db->getUserInfo($mail)['surname'];
                    $_SESSION['isAdmin'] = $db->getUserInfo($mail)['isAdmin'];
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
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);

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

    //===== REVIEW =====
    public function getReviewFromUser()
    {
        $userID = $_SESSION['userID'];

        $rqt = "SELECT r.*, a.* 
                FROM Review r
                JOIN Annonce a on a.annonceID = r.annonceID
                WHERE userID = :userID
                ORDER BY r.grade desc;";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return false;
        }
    }

    public function getReviewFromAnnonce($annonceID)
    {

        $rqt = "SELECT r.*, u.name, u.surname 
                FROM Review r
                JOIN User u on u.userID = r.userID
                WHERE r.annonceID = :annonceID";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return false;
        }
    }

    public function insertReview($annonceID, $grade, $comment, $date)
    {
        $userID = $_SESSION['userID'];
        $existingRecord = $this->getExistingReview($userID, $annonceID, $date);
        $hasReservation = $this->checkUserReservation($userID, $annonceID);


        if ($existingRecord) {
            $_SESSION['errorMsg'] = "Erreur, vous avez déjà partagé un avis sur cette annonce.";
            return false;
        }

        if ($hasReservation) {
            $rqt = "INSERT INTO Review (userID, annonceID, grade, comment, date) VALUES (:userID, :annonceID, :grade, :comment, :date)";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
            $stmt->bindParam(':grade', $grade, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $updateRqt = "UPDATE Reservation SET hasReviewed = TRUE WHERE userID = :userID AND annonceID = :annonceID";
                $updateStmt = $this->conn->prepare($updateRqt);
                $updateStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
                $updateStmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
                $updateStmt->execute();
                $_SESSION['successMsg'] = "Avis bien posté";
                return true;
            } else {
                return false;
            }
        } else {
            $_SESSION['errorMsg'] = "Erreur, vous devez avoir une réservation valide ou terminée pour partager un avis.";
            return false;
        }
    }


    private function checkUserReservation($userID, $annonceID)
    {
        $rqt = "SELECT dateFin, hasReviewed FROM Reservation WHERE userID = :userID AND annonceID = :annonceID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result !== false) {
            $dateFin = $result['dateFin'];
            $hasReviewed = $result['hasReviewed'];
            $dateFinObj = new DateTime($dateFin);
            $dateToday = new DateTime('now');
            return $dateFinObj < $dateToday && !$hasReviewed;
        } else {
            return false;
        }
    }

    private function getExistingReview($userID, $annonceID, $date)
    {
        $rqt = "SELECT * FROM Review WHERE userID = :userID AND annonceID = :annonceID AND date = :date";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //===== =================================== =====

    //===== RESERVATION =====
    public function insertReservation($annonceID, $dateDebut, $dateFin)
    {
        $rqt = "SELECT * FROM Reservation WHERE annonceID = :annonceID 
                AND (:dateDebut BETWEEN dateDebut AND dateFin
                  OR :dateFin BETWEEN dateDebut AND dateFin
                  OR dateDebut BETWEEN :dateDebut AND :dateFin
                  OR dateFin BETWEEN :dateDebut AND :dateFin)";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':dateDebut', $dateDebut, PDO::PARAM_STR);
        $stmt->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['errorMsg'] = "Une des dates entrées déborde sur une réservation.";
            return false;
        } else {
            $userID = $_SESSION['userID'];

            $rqt = "INSERT INTO Reservation (userID, annonceID, dateDebut, dateFin) VALUES (:userID, :annonceID, :dateDebut, :dateFin)";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
            $stmt->bindParam(':dateDebut', $dateDebut, PDO::PARAM_STR);
            $stmt->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }


    //Récupérer les annonces réservées par le user actuel
    public function getReservation($userID)
    {
        $rqt = "SELECT * FROM Reservation r
                JOIN Annonce a ON a.annonceID = r.annonceID
                WHERE r.userID = :userID
                ORDER BY r.dateDebut asc;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //===== ADMIN =====


    //===== ADD ANNONCE =====

    function insertAnnonce($title, $city, $price, $typeLogement, $image)
    {
        $rqt = "INSERT INTO Annonce (title, city, price, typeLogement, image)
          VALUES (:title, :city, :price, :typeLogement, :image);";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':typeLogement', $typeLogement, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Annonce bien ajoutée!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Annonce pas ajoutée.";
            return false;
        }
    }

    function deleteAnnonce($annonceID)
    {
        $rqt = "DELETE FROM ServiceAnnonce WHERE annonceID = :annonceID;
                DELETE FROM EquipementAnnonce WHERE annonceID = :annonceID;
                DELETE FROM Annonce WHERE annonceID = :annonceID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Annonce supprimée!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Annonce non supprimée.";
            return false;
        }
    }

    function getAllUser()
    {
        $rqt = "SELECT * FROM User";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function addUser($mail, $pwd, $isAdmin, $name, $surname, $phoneNbr)
    {
        $rqt = "SELECT * from User where mail = :mail";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $_SESSION['errorMsg'] = "Un compte existe déjà avec cette adresse mail.";
            return false;
        } else {
            $sql = "INSERT INTO User (mail, pwd, isAdmin, name, surname, phoneNbr) VALUES (:mail,:pwd,:isAdmin,:name,:surname,:phoneNbr)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
            $stmt->bindParam(':pwd', $pwd, PDO::PARAM_STR);
            $stmt->bindParam(':isAdmin', $isAdmin, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
            $stmt->bindParam(':phoneNbr', $phoneNbr, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $_SESSION['successMsg'] = "Utilisateur créé!";
                return true;
            } else {
                $_SESSION['errorMsg'] = "Utilsateur non créé.";
                return false;
            }
        }
    }

    function deleteUser($userID)
    {
        $rqt = "DELETE FROM Favorite
                WHERE userID = :userID;
                DELETE FROM Reservation
                WHERE userID = :userID;
                DELETE FROM Review
                WHERE userID = :userID;
                DELETE FROM User
                WHERE userID = :userID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "User supprimé!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "User non supprimé.";
            return false;
        }
    }

    function getAllReview()
    {
        $rqt = "SELECT r.*, a.*, u.*
                FROM Review r
                JOIN Annonce a on a.annonceID = r.annonceID
                JOIN User u on u.userID = r.userID
                ORDER BY r.annonceID asc;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function deleteReview($reviewID)
    {
        $rqt = "DELETE FROM Review WHERE reviewID = :reviewID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':reviewID', $reviewID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Commentaire supprimé!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Commentaire non supprimé.";
            return false;
        }
    }
}
