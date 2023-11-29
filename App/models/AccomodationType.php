<?php
class AccomodationType
{

    private $conn;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        $this->conn = $db->conn;
    }

    //Récupérer les types de logement
    public function getAccomodationType()
    {
        $rqt = "SELECT * FROM AccomodationType";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //AJouter un type de logement
    public function addAccomodationType($value)
    {
        $rqt = "INSERT INTO AccomodationType (name) VALUES (:value)";
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


    //Avoir les annoncesID qui ont tel service
    public function getAccomodationIdFromAccomodationTypeId($accomodationTypeId)
    {
        $rqt1 = "SELECT a.accomodationID
                FROM Accomodation a
                JOIN AccomodationType at
                ON at.name = a.accomodationType
                WHERE at.accomodationTypeID = :accomodationTypeId;";
        $stmt1 = $this->conn->prepare($rqt1);
        $stmt1->bindParam(':accomodationTypeId', $accomodationTypeId, PDO::PARAM_INT);
        $stmt1->execute();

        return $stmt1->fetchAll(PDO::FETCH_ASSOC);
    }


    //SUpprimer un type de logement
    public function deleteAccomodationType($id)
    {
        $model = new AccomodationType();
        $accomodationTypeIDs = $model->getAccomodationIdFromAccomodationTypeId($id);

        foreach ($accomodationTypeIDs as $accoID) {
            $rqt = "UPDATE Accomodation SET accomodationType = 'UNDEFINED' WHERE accomodationID=:id";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':id', $accoID['accomodationID'], PDO::PARAM_INT);
            $stmt->execute();
        }

        $model = new AccomodationType();
        $model->addAccomodationType('UNDEFINED');

        $rqt2 = "DELETE FROM AccomodationType WHERE accomodationTypeID = :id";
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

    //Modifier un type de logement
    public function modifyAccomodationType($value, $accomodationTypeID)
    {
        $model = new AccomodationType();
        $accomodationTypeIDs = $model->getAccomodationIdFromAccomodationTypeId($accomodationTypeID);

        foreach ($accomodationTypeIDs as $accoID) {
            $rqt = "UPDATE Accomodation SET accomodationType = :value WHERE accomodationID=:accoID";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':accoID', $accoID['accomodationID'], PDO::PARAM_INT);
            $stmt->bindParam(':value', $value, PDO::PARAM_STR);
            $stmt->execute();
        }

        $rqt = "UPDATE AccomodationType SET name = :value WHERE accomodationTypeID=:accomodationTypeID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
        $stmt->bindParam(':accomodationTypeID', $accomodationTypeID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Type de logement modifié!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Type de logement non modifié.";
            return false;
        }
    }
}
