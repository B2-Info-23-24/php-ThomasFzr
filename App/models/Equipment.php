<?php
class Equipment
{

    private $conn;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        $this->conn = $db->conn;
    }

    //Get equipments
    public function getEquipment()
    {
        $rqt = "SELECT * FROM Equipment";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get equipments of an accommodation
    public function getEquipmentFromAccommodation($accommodationID)
    {
        $sql = "SELECT e.* FROM Equipment e
                JOIN EquipmentAccommodation ea ON e.equipmentID = ea.equipmentID
                WHERE ea.accommodationID = :accommodationID";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Add an equipment
    public function addEquipment($value)
    {
        $rqt = "INSERT INTO Equipment (name) VALUES (:value)";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Equipement ajouté!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Equipement non ajouté.";
            return false;
        }
    }

    //Get the accommodationID that have a specific equipment
    public function getAccommodationIdFromEquipmentId($equipmentID)
    {
        $rqt = "SELECT a.accommodationID
                FROM Accommodation a
                JOIN EquipmentAccommodation sa
                ON sa.accommodationID = a.accommodationID
                JOIN Equipment s 
                ON s.equipmentID = sa.equipmentID
                WHERE s.equipmentID =:equipmentID;";
        $stmt1 = $this->conn->prepare($rqt);
        $stmt1->bindParam(':equipmentID', $equipmentID, PDO::PARAM_INT);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    }

    //Delete an equipment
    public function deleteEquipment($equipmentID)
    {
        $model = new Equipment();
        $accommodationTypeIDs = $model->getAccommodationIdFromEquipmentId($equipmentID);

        foreach ($accommodationTypeIDs as $accoID) {
            $rqt = "DELETE FROM EquipmentAccommodation WHERE accommodationID =:accoID AND equipmentID = :equipmentID";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':accoID', $accoID['accommodationID'], PDO::PARAM_INT);
            $stmt->bindParam(':equipmentID', $equipmentID, PDO::PARAM_INT);
            $stmt->execute();
        }

        $rqt2 = "DELETE FROM Equipment WHERE equipmentID = :equipmentID";
        $stmt2 = $this->conn->prepare($rqt2);
        $stmt2->bindParam(':equipmentID', $equipmentID, PDO::PARAM_INT);
        if ($stmt2->execute()) {
            $_SESSION['successMsg'] = "Equipement supprimé!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Equipement non supprimé.";
            return false;
        }
    }

    //Update an equipment
    public function modifyEquipment($value, $equipmentID)
    {
        $rqt = "UPDATE Equipment SET name = :value WHERE equipmentID=:equipmentID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        $stmt->bindParam(':equipmentID', $equipmentID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Equipement modifié!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Equipement non modifié.";
            return false;
        }
    }

    //Add an equipment to an accommodation
    public function addEquipmentToAccommodation($accommodationID, $equipmentID)
    {
        $rowExist = "SELECT * FROM EquipmentAccommodation
                    WHERE equipmentID=:equipmentID 
                    AND accommodationID=:accommodationID;";
        $count = $this->conn->prepare($rowExist);
        $count->bindParam(':equipmentID', $equipmentID, PDO::PARAM_INT);
        $count->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        $count->execute();
        if ($count->rowCount() > 0) {
            $_SESSION['errorMsg'] = "Equipement déjà présent dans cette annonce.";
            return false;
        } else {
            $rqt = "INSERT INTO EquipmentAccommodation (equipmentID,  accommodationID)
                VALUES (:equipmentID, :accommodationID);";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':equipmentID', $equipmentID, PDO::PARAM_INT);
            $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $_SESSION['successMsg'] = "Equipement ajouté à cette annonce!";
                return true;
            } else {
                $_SESSION['errorMsg'] = "Equipement non ajouté à cette annonce.";
                return false;
            }
        }
    }

    //Add equipment while creating a new accommodation
    public function addEquipmentToNewAccommodation($accommodationID, $equipmentId)
    {
        $rqt = "INSERT INTO EquipmentAccommodation (equipmentID,  accommodationID)
    VALUES (:equipmentID, :accommodationID);";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':equipmentID', $equipmentId, PDO::PARAM_INT);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Add an equipment to an accommodation
    public function deleteEquipmentOfAccommodation($accommodationID, $equipmentID)
    {
        $rqt = "DELETE FROM EquipmentAccommodation 
                WHERE equipmentID = :equipmentID
                AND accommodationID = :accommodationID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':equipmentID', $equipmentID, PDO::PARAM_INT);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Equipement supprimé de cette annonce!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Equipement non supprimé de cette annonce.";
            return false;
        }
    }
}
