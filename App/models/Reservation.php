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


    public function insertReservation($accomodationID, $startDate, $endDate, $totalPrice)
    {
        $rqt = "SELECT * FROM Reservation WHERE accomodationID = :accomodationID 
                AND (:startDate BETWEEN startDate AND endDate
                  OR :endDate BETWEEN startDate AND endDate
                  OR startDate BETWEEN :startDate AND :endDate
                  OR endDate BETWEEN :startDate AND :endDate)";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['errorMsg'] = "Une des dates entrées déborde sur une réservation.";
            return false;
        } else {
            $userID = $_SESSION['userID'];

            $rqt = "INSERT INTO Reservation (userID, accomodationID, startDate, endDate, totalPrice) VALUES (:userID, :accomodationID, :startDate, :endDate, :totalPrice)";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
            $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
            $stmt->bindParam(':totalPrice', $totalPrice, PDO::PARAM_INT);


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
                JOIN Accomodation a ON a.accomodationID = r.accomodationID
                WHERE r.userID = :userID
                ORDER BY r.startDate asc;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkUserReservation($userID, $accomodationID)
    {
        $rqt = "SELECT endDate, hasReviewed FROM Reservation WHERE userID = :userID AND accomodationID = :accomodationID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result !== false) {
            $endDate = $result['endDate'];
            $hasReviewed = $result['hasReviewed'];
            $endDateObj = new DateTime($endDate);
            $dateToday = new DateTime('now');
            return $endDateObj < $dateToday && !$hasReviewed;
        } else {
            return false;
        }
    }

}