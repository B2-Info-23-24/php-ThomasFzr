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

    //Récupérer les annonces ajoutées en favoris par le user actuel
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

    //Ajouter en favoris une annonce
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

    //Retirer une annonce des favoris
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

    //Tester si une annonce a été ajouté en favoris par le user actuel
    public function isInFavorite($accommodationID)
    {
        $userID = $_SESSION['userID'];

        $rqt = "SELECT Favorite.*
            FROM Favorite
            JOIN Accommodation ON Accommodation.accommodationID = Favorite.accommodationID
            JOIN User ON Favorite.userID = User.userID
            WHERE User.userID = :userID
              AND Accommodation.accommodationID = :accommodationID";

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

    function getAllFavorite()
    {
        $rqt = "SELECT * FROM Favorite
                JOIN User u on Favorite.userID = u.userID
                JOIN Accommodation a on a.accommodationID = Favorite.accommodationID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
