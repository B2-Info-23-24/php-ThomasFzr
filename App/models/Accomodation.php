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

    //===== ADD ANNONCE =====

    function insertAccomodation($title, $city, $price, $typeLogement, $image)
    {
        $rqt = "INSERT INTO Accomodation (title, city, price, typeLogement, image)
           VALUES (:title, :city, :price, :typeLogement, :image);";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':typeLogement', $typeLogement, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Annonce ajoutée!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Annonce non ajoutée.";
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
