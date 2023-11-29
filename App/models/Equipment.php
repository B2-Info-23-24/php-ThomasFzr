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

    //Récupérer les équipements
    public function getEquipment()
    {
        $rqt = "SELECT * FROM Equipment";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les équipements d'une annonce avec leur nom
    public function getEquipmentFromAccomodation($accomodationID)
    {
        $sql = "SELECT e.* FROM Equipment e
                JOIN EquipmentAccomodation ea ON e.equipmentID = ea.equipmentID
                WHERE ea.accomodationID = :accomodationID";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //AJouter un equipement
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

    //Avoir les annoncesID qui ont tel equipement
    public function getAccomodationIdFromEquipmentId($equipmentID)
    {
        $rqt = "SELECT a.accomodationID
                FROM Accomodation a
                JOIN EquipmentAccomodation sa
                ON sa.accomodationID = a.accomodationID
                JOIN Equipment s 
                ON s.equipmentID = sa.equipmentID
                WHERE s.equipmentID =:equipmentID;";
        $stmt1 = $this->conn->prepare($rqt);
        $stmt1->bindParam(':equipmentID', $equipmentID, PDO::PARAM_INT);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    }

    //SUpprimer un equipement
    public function deleteEquipment($equipmentID)
    {
        $model = new Equipment();
        $accomodationTypeIDs = $model->getAccomodationIdFromEquipmentId($equipmentID);

        foreach ($accomodationTypeIDs as $accoID) {
            $rqt = "DELETE FROM EquipmentAccomodation WHERE accomodationID =:accoID AND equipmentID = :equipmentID";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':accoID', $accoID['accomodationID'], PDO::PARAM_INT);
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

    //Modifier un equipement
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

    //Ajouter un equipment a une annonce
    public function addEquipmentToAccomodation($accomodationID, $equipmentID,)
    {
        $rowExist = "SELECT * FROM EquipmentAccomodation
                    WHERE equipmentID=:equipmentID 
                    AND accomodationID=:accomodationID;";
        $count = $this->conn->prepare($rowExist);
        $count->bindParam(':equipmentID', $equipmentID, PDO::PARAM_INT);
        $count->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
        $count->execute();
        if ($count->rowCount() > 0) {
            $_SESSION['errorMsg'] = "Equipement déjà présent dans cette annonce.";
            return false;
        } else {
            $rqt = "INSERT INTO EquipmentAccomodation (equipmentID,  accomodationID)
                VALUES (:equipmentID, :accomodationID);";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':equipmentID', $equipmentID, PDO::PARAM_INT);
            $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $_SESSION['successMsg'] = "Equipement ajouté à cette annonce!";
                return true;
            } else {
                $_SESSION['errorMsg'] = "Equipement non ajouté à cette annonce.";
                return false;
            }
        }
    }

    //Ajouter un equipment a une annonce
    public function deleteEquipmentOfAccomodation($accomodationID, $equipmentID)
    {
        $rqt = "DELETE FROM EquipmentAccomodation 
                WHERE equipmentID = :equipmentID
                AND accomodationID = :accomodationID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':equipmentID', $equipmentID, PDO::PARAM_INT);
        $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Equipement supprimé de cette annonce!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Equipement non supprimé de cette annonce.";
            return false;
        }
    }
}
