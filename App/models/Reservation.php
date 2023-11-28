<?php
class Reservation
{

    private $conn;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        $this->conn = $db->conn;
    }


    public function insertReservation($annonceID, $dateDebut, $dateFin)
    {
        $rqt = "SELECT * FROM Reservation WHERE annonceID = :annonceID 
                AND (:dateDebut BETWEEN dateDebut AND dateFin
                  OR :dateFin BETWEEN dateDebut AND dateFin
                  OR dateDebut BETWEEN :dateDebut AND :dateFin
                  OR dateFin BETWEEN :dateDebut AND :dateFin)";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':dateDebut', $dateDebut, PDO::PARAM_STR);
        $stmt->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['errorMsg'] = "Une des dates entrées déborde sur une réservation.";
            return false;
        } else {
            $userID = $_SESSION['userID'];

            $rqt = "INSERT INTO Reservation (userID, annonceID, dateDebut, dateFin) VALUES (:userID, :annonceID, :dateDebut, :dateFin)";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
            $stmt->bindParam(':dateDebut', $dateDebut, PDO::PARAM_STR);
            $stmt->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }


    //Récupérer les annonces réservées par le user actuel
    public function getReservation($userID)
    {
        $rqt = "SELECT * FROM Reservation r
                JOIN Annonce a ON a.annonceID = r.annonceID
                WHERE r.userID = :userID
                ORDER BY r.dateDebut asc;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkUserReservation($userID, $annonceID)
    {
        $rqt = "SELECT dateFin, hasReviewed FROM Reservation WHERE userID = :userID AND annonceID = :annonceID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result !== false) {
            $dateFin = $result['dateFin'];
            $hasReviewed = $result['hasReviewed'];
            $dateFinObj = new DateTime($dateFin);
            $dateToday = new DateTime('now');
            return $dateFinObj < $dateToday && !$hasReviewed;
        } else {
            return false;
        }
    }

}