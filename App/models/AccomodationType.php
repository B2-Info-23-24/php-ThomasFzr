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
}
