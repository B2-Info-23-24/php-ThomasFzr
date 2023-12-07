<?php
class Accommodation
{

    private $conn;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        $this->conn = $db->conn;
    }

    //Get all accommodations
    public function getAccommodation($requete)
    {
        $rqt = "SELECT * FROM Accommodation $requete";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Get details of an accommodation
    public function getDetailsAccommodation($accommodationID)
    {
        $rqt = "SELECT * FROM Accommodation WHERE accommodationID = :accommodationID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //get the last accommodation inserted in the table
    public function getLastAccommodationId()
    {
        $rqt = "SELECT accommodationID 
                FROM Accommodation 
                ORDER BY accommodationID DESC 
                LIMIT 1;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    //===== ADD accommodation =====

    function insertAccommodation($title, $city, $price, $accommodationType, $image)
    {
        $rqt = "INSERT INTO Accommodation (title, city, price, accommodationType, image)
           VALUES (:title, :city, :price, :accommodationType, :image);";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':accommodationType', $accommodationType, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return true;
        } else {
            return false;
        }
    }

    //===== DELETE accommodation =====

    function deleteAccommodation($accommodationID)
    {
        $rqt = "DELETE FROM ServiceAccommodation WHERE accommodationID = :accommodationID;
                DELETE FROM EquipmentAccommodation WHERE accommodationID = :accommodationID;
                DELETE FROM Favorite WHERE accommodationID = :accommodationID;
                DELETE FROM Review WHERE accommodationID = :accommodationID;
                DELETE FROM Reservation WHERE accommodationID = :accommodationID;
                DELETE FROM Accommodation WHERE accommodationID = :accommodationID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Annonce supprimée!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Annonce non supprimée.";
            return false;
        }
    }

    //===== Update accommodation =====

    function modifyAccommodation($column, $value, $accommodationID)
    {
        $rqt = "UPDATE Accommodation SET $column = :value WHERE accommodationID=:accommodationID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam('value', $value, PDO::PARAM_STR);
        $stmt->bindParam('accommodationID', $accommodationID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Get the price of an accommodation
    public function getPriceOfAccommodation($accommodationID)
    {
        $rqt = "SELECT price 
                FROM Accommodation 
                WHERE accommodationID =:accommodationID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
