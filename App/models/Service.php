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
}
