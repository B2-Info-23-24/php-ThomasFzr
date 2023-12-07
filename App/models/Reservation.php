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


    public function insertReservation($accommodationID, $startDate, $endDate, $totalPrice)
    {
        $rqt = "SELECT * FROM Reservation WHERE accommodationID = :accommodationID 
                AND (:startDate BETWEEN startDate AND endDate
                  OR :endDate BETWEEN startDate AND endDate
                  OR startDate BETWEEN :startDate AND :endDate
                  OR endDate BETWEEN :startDate AND :endDate)";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['errorMsg'] = "Une des dates entrées déborde sur une réservation.";
            return false;
        } else {
            $userID = $_SESSION['userID'];

            $rqt = "INSERT INTO Reservation (userID, accommodationID, startDate, endDate, totalPrice) VALUES (:userID, :accommodationID, :startDate, :endDate, :totalPrice)";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
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


    //Get accommodation reserved for a specific user
    public function getReservation($userID)
    {
        $rqt = "SELECT * FROM Reservation r
                JOIN Accommodation a ON a.accommodationID = r.accommodationID
                WHERE r.userID = :userID
                ORDER BY r.startDate asc;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkUserReservation($userID, $accommodationID)
    {
        $rqt = "SELECT endDate, hasReviewed FROM Reservation WHERE userID = :userID AND accommodationID = :accommodationID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
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

    function getAllReservation()
    {
        $rqt = "SELECT * FROM Reservation 
                JOIN User u on Reservation.userID = u.userID
                JOIN Accommodation a on a.accommodationID = Reservation.accommodationID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function deleteReservation($reservationID)
    {
        $rqt = "DELETE FROM Reservation WHERE reservationID = :reservationID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':reservationID', $reservationID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Reservation supprimée!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Reservation non supprimée.";
            return false;
        }
    }

    function addReservation($accommodationID,  $startDate, $endDate, $totalPrice, $userID)
    {
        $rqt = "SELECT * FROM Reservation WHERE accommodationID = :accommodationID 
        AND (:startDate BETWEEN startDate AND endDate
          OR :endDate BETWEEN startDate AND endDate
          OR startDate BETWEEN :startDate AND :endDate
          OR endDate BETWEEN :startDate AND :endDate)";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['errorMsg'] = "Une des dates entrées déborde sur une réservation.";
            return false;
        } else {


            $rqt = "INSERT INTO Reservation (userID, accommodationID, startDate, endDate, totalPrice) VALUES (:userID, :accommodationID, :startDate, :endDate, :totalPrice)";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':accommodationID', $accommodationID, PDO::PARAM_INT);
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
}
