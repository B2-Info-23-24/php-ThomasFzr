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
}
