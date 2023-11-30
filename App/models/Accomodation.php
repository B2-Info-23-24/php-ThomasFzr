<?php
class Accomodation
{

    private $conn;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        $this->conn = $db->conn;
    }

    //Récupérer toutes les annonces
    public function getAccomodation($requete)
    {
        $rqt = "SELECT * FROM Accomodation $requete";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Récupérer détails d'une annonce
    public function getDetailsAccomodation($accomodationID)
    {
        $rqt = "SELECT * FROM Accomodation WHERE accomodationID = :accomodationID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLastAccomodationId()
    {
        $rqt = "SELECT accomodationID 
                FROM Accomodation 
                ORDER BY accomodationID DESC 
                LIMIT 1;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    //===== ADD ANNONCE =====

    function insertAccomodation($title, $city, $price, $accomodationType, $image)
    {
        $rqt = "INSERT INTO Accomodation (title, city, price, accomodationType, image)
           VALUES (:title, :city, :price, :accomodationType, :image);";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':accomodationType', $accomodationType, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);

        if ($stmt->execute()) {
          
            return true;
        } else {
            return false;
        }
    }

    //===== DELETE ANNONCE =====

    function deleteAccomodation($accomodationID)
    {
        $rqt = "DELETE FROM ServiceAccomodation WHERE accomodationID = :accomodationID;
                DELETE FROM EquipmentAccomodation WHERE accomodationID = :accomodationID;
                DELETE FROM Favorite WHERE accomodationID = :accomodationID;
                DELETE FROM Review WHERE accomodationID = :accomodationID;
                DELETE FROM Reservation WHERE accomodationID = :accomodationID;
                DELETE FROM Accomodation WHERE accomodationID = :accomodationID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Annonce supprimée!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Annonce non supprimée.";
            return false;
        }
    }

    //===== Modifier annonce =====

    function modifyAccomodation($column, $value, $accomodationID)
    {
        $rqt = "UPDATE Accomodation SET $column = :value WHERE accomodationID=:accomodationID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam('value', $value, PDO::PARAM_STR);
        $stmt->bindParam('accomodationID', $accomodationID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
