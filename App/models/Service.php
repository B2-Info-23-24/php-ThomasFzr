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

    //Récupérer les services
    public function getService()
    {
        $rqt = "SELECT * FROM Service";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les services d'une annonce avec leur nom
    public function getServiceFromAccomodation($accomodationID)
    {
        $sql = "SELECT s.* FROM Service s
            JOIN ServiceAccomodation sa ON s.serviceID = sa.serviceID
            WHERE sa.accomodationID = :accomodationID";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //AJouter un service
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

    //Avoir les annoncesID qui ont tel service
    public function getAccomodationIdFromServiceId($serviceID)
    {
        $rqt = "SELECT a.accomodationID
                FROM Accomodation a
                JOIN ServiceAccomodation sa
                ON sa.accomodationID = a.accomodationID
                JOIN Service s 
                ON s.serviceID = sa.serviceID
                WHERE s.serviceID =:serviceID;";
        $stmt1 = $this->conn->prepare($rqt);
        $stmt1->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    }

    //SUpprimer un service
    public function deleteService($serviceID)
    {
        $model = new Service();
        $accomodationTypeIDs = $model->getAccomodationIdFromServiceId($serviceID);

        foreach ($accomodationTypeIDs as $accoID) {
            $rqt = "DELETE FROM ServiceAccomodation WHERE accomodationID =:accoID AND serviceID = :serviceID";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':accoID', $accoID['accomodationID'], PDO::PARAM_INT);
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

    //Modifier un service
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
}
