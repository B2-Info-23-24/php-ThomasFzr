<?php
class Service
{

    private $conn;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        $this->conn = $db->conn;
    }

    //get all the services
    public function getService()
    {
        $rqt = "SELECT * FROM Service";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get the services of an accommodation
    public function getServiceFromAccommodation($accommodationID)
    {
        $sql = "SELECT s.* FROM Service s
            JOIN ServiceAccommodation sa ON s.serviceID = sa.serviceID
            WHERE sa.accommodationID = :accommodationID";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Add a service
    public function addService($value)
    {
        $rqt = "INSERT INTO Service (name) VALUES (:value)";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Service ajouté!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Service non ajouté.";
            return false;
        }
    }

    //Get accommodationID from a serviceID
    public function getAccommodationIdFromServiceId($serviceID)
    {
        $rqt = "SELECT a.accommodationID
                FROM Accommodation a
                JOIN ServiceAccommodation sa
                ON sa.accommodationID = a.accommodationID
                JOIN Service s 
                ON s.serviceID = sa.serviceID
                WHERE s.serviceID =:serviceID;";
        $stmt1 = $this->conn->prepare($rqt);
        $stmt1->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    }

    //delete a service
    public function deleteService($serviceID)
    {
        $model = new Service();
        $accommodationTypeIDs = $model->getAccommodationIdFromServiceId($serviceID);

        foreach ($accommodationTypeIDs as $accoID) {
            $rqt = "DELETE FROM ServiceAccommodation WHERE accommodationID =:accoID AND serviceID = :serviceID";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':accoID', $accoID['accommodationID'], PDO::PARAM_INT);
            $stmt->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
            $stmt->execute();
        }

        $rqt2 = "DELETE FROM Service WHERE serviceID = :serviceID";
        $stmt2 = $this->conn->prepare($rqt2);
        $stmt2->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
        if ($stmt2->execute()) {
            $_SESSION['successMsg'] = "Service supprimé!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Service non supprimé.";
            return false;
        }
    }

    //Update a service
    public function modifyService($value, $serviceID)
    {
        $rqt = "UPDATE Service SET name = :value WHERE serviceID=:serviceID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        $stmt->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Service modifié!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Service non modifié.";
            return false;
        }
    }

    //Add a service to an accommodation
    public function addServiceToAccommodation($accommodationID, $serviceID)
    {
        $rowExist = "SELECT * FROM ServiceAccommodation
                    WHERE serviceID=:serviceID 
                    AND accommodationID=:accommodationID;";
        $count = $this->conn->prepare($rowExist);
        $count->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
        $count->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        $count->execute();
        if ($count->rowCount() > 0) {
            $_SESSION['errorMsg'] = "Service déjà présent dans cette annonce.";
            return false;
        } else {
            $rqt = "INSERT INTO ServiceAccommodation (serviceID,  accommodationID)
                VALUES (:serviceID, :accommodationID);";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
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

    public function addServiceToNewAccommodation($accommodationID, $serciceId)
    {
        $rqt = "INSERT INTO ServiceAccommodation (serviceID,  accommodationID)
                VALUES (:serviceID, :accommodationID);";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':serviceID', $serciceId, PDO::PARAM_INT);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Delete service from an accommodation
    public function deleteServiceOfAccommodation($accommodationID, $serviceID)
    {
        $rqt = "DELETE FROM ServiceAccommodation 
                WHERE serviceID = :serviceID
                AND accommodationID = :accommodationID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Service supprimé de cette annonce!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Service non supprimé de cette annonce.";
            return false;
        }
    }
}
