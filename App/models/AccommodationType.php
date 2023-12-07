<?php
class AccommodationType
{

    private $conn;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        $this->conn = $db->conn;
    }

    //Get the accommodation types
    public function getAccommodationType()
    {
        $rqt = "SELECT * FROM AccommodationType";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Add an accommodation type
    public function addAccommodationType($value)
    {
        $rqt = "INSERT INTO AccommodationType (name) VALUES (:value)";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Type de logement ajouté!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Type de logement non ajouté.";
            return false;
        }
    }


    //Get accommodationID from accommodationTypeID
    public function getAccommodationIdFromAccommodationTypeId($accommodationTypeId)
    {
        $rqt1 = "SELECT a.accommodationID
                FROM Accommodation a
                JOIN AccommodationType at
                ON at.name = a.accommodationType
                WHERE at.accommodationTypeID = :accommodationTypeId;";
        $stmt1 = $this->conn->prepare($rqt1);
        $stmt1->bindParam(':accommodationTypeId', $accommodationTypeId, PDO::PARAM_INT);
        $stmt1->execute();

        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    }


    //Delete an accommodation type
    public function deleteAccommodationType($id)
    {
        $model = new AccommodationType();
        $accommodationTypeIDs = $model->getAccommodationIdFromAccommodationTypeId($id);

        foreach ($accommodationTypeIDs as $accoID) {
            $rqt = "UPDATE Accommodation SET accommodationType = 'UNDEFINED' WHERE accommodationID=:id";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':id', $accoID['accommodationID'], PDO::PARAM_INT);
            $stmt->execute();
        }

        $model = new AccommodationType();
        $model->addAccommodationType('UNDEFINED');

        $rqt2 = "DELETE FROM AccommodationType WHERE accommodationTypeID = :id";
        $stmt2 = $this->conn->prepare($rqt2);
        $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt2->execute()) {
            $_SESSION['successMsg'] = "Type de logement supprimé!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Type de logement non supprimé.";
            return false;
        }
    }

    //Update an accommodation type
    public function modifyAccommodationType($value, $accommodationTypeID)
    {
        $model = new AccommodationType();
        $accommodationTypeIDs = $model->getAccommodationIdFromAccommodationTypeId($accommodationTypeID);

        foreach ($accommodationTypeIDs as $accoID) {
            $rqt = "UPDATE Accommodation SET accommodationType = :value WHERE accommodationID=:accoID";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':accoID', $accoID['accommodationID'], PDO::PARAM_INT);
            $stmt->bindParam(':value', $value, PDO::PARAM_STR);
            $stmt->execute();
        }

        $rqt = "UPDATE AccommodationType SET name = :value WHERE accommodationTypeID=:accommodationTypeID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        $stmt->bindParam(':accommodationTypeID', $accommodationTypeID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Type de logement modifié!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Type de logement non modifié.";
            return false;
        }
    }
}
