<?php
class Favorite
{

    private $conn;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        $this->conn = $db->conn;
    }

    //Get accommodations that are in favorite for a specific user
    public function getFavorite($userID)
    {
        $rqt = "SELECT Accommodation.*
                FROM Accommodation
                JOIN Favorite ON Accommodation.accommodationID = Favorite.accommodationID
                JOIN User ON Favorite.userID = User.userID
                WHERE User.userID = :userID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Add an accommodation to favorite
    public function addToFavorite($accommodationID)
    {
        $userID = $_SESSION['userID'];

        $rqt = "INSERT INTO Favorite (userID, accommodationID) VALUES (:userID, :accommodationID)";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Remove an accommodation from favoritr
    public function removeFromFavorite($accommodationID)
    {
        $userID = $_SESSION['userID'];
        $rqt = "DELETE FROM Favorite WHERE userID = :userID AND accommodationID = :accommodationID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //is the accommodation in favorite for the specific user
    public function isInFavorite($accommodationID)
    {
        $userID = $_SESSION['userID'];

        $rqt = "SELECT * FROM Favorite 
                WHERE userID = :userID
                AND accommodationID = :accommodationID";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);

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

    //===== ADMIN =====
    function getAllFavorite()
    {
        $rqt = "SELECT * FROM Favorite
                JOIN User u on Favorite.userID = u.userID
                JOIN Accommodation a on a.accommodationID = Favorite.accommodationID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function addFavorite($userID, $accommodationID)
    {
        $rqt = "SELECT * from Favorite 
                WHERE userID = :userID
                AND accommodationID = :accommodationID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $_SESSION['errorMsg'] = "Ce logement est déjà en favoris pour cet utilisateur.";
            return false;
        } else {

            $rqt = "INSERT INTO Favorite (userID, accommodationID) VALUES (:userID, :accommodationID)";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['successMsg'] = "Logement ajouté en favoris";
                return true;
            } else {
                return false;
            }
        }
    }

    function deleteFavorite($favoriteID)
    {
        $rqt = "DELETE FROM Favorite WHERE favoriteID = :favoriteID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':favoriteID', $favoriteID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Supprimé des favoris!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Ajouté en favoris.";
            return false;
        }
    }
}
