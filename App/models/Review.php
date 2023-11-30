<?php
class Review
{

    private $conn;
    private $reservation;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        require_once __DIR__ . '/../models/Reservation.php';
        $db = new Database();
        $this->conn = $db->conn;
        $this->reservation = new Reservation();
    }

    //===== REVIEW =====
    public function getReviewFromUser()
    {
        $userID = $_SESSION['userID'];

        $rqt = "SELECT r.*, a.* 
            FROM Review r
            JOIN Accomodation a on a.accomodationID = r.accomodationID
            WHERE userID = :userID
            ORDER BY r.grade desc;";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return false;
        }
    }

    public function getReviewFromAccomodation($accomodationID)
    {

        $rqt = "SELECT r.*, u.name, u.surname 
            FROM Review r
            JOIN User u on u.userID = r.userID
            WHERE r.accomodationID = :accomodationID";

        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return false;
        }
    }

    public function insertReview($accomodationID, $grade, $comment, $date)
    {
        $userID = $_SESSION['userID'];
        $existingRecord = $this->getExistingReview($userID, $accomodationID, $date);
        $hasReservation = $this->reservation->checkUserReservation($userID, $accomodationID);


        if ($existingRecord) {
            $_SESSION['errorMsg'] = "Erreur, vous avez déjà partagé un avis sur cette annonce.";
            return false;
        }

        if ($hasReservation) {
            $rqt = "INSERT INTO Review (userID, accomodationID, grade, comment, date) VALUES (:userID, :accomodationID, :grade, :comment, :date)";
            $stmt = $this->conn->prepare($rqt);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
            $stmt->bindParam(':grade', $grade, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $updateRqt = "UPDATE Reservation SET hasReviewed = TRUE WHERE userID = :userID AND accomodationID = :accomodationID";
                $updateStmt = $this->conn->prepare($updateRqt);
                $updateStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
                $updateStmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
                $updateStmt->execute();
                $_SESSION['successMsg'] = "Avis bien posté";
                return true;
            } else {
                return false;
            }
        } else {
            $_SESSION['errorMsg'] = "Erreur, vous devez avoir une réservation valide ou terminée pour partager un avis.";
            return false;
        }
    }

    private function getExistingReview($userID, $accomodationID, $date)
    {
        $rqt = "SELECT * FROM Review WHERE userID = :userID AND accomodationID = :accomodationID AND date = :date";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //===== ADMIN =====

    //Recuperer tous les avis
    function getAllReview()
    {
        $rqt = "SELECT r.*, a.*, u.*
                FROM Review r
                JOIN Accomodation a on a.accomodationID = r.accomodationID
                JOIN User u on u.userID = r.userID
                ORDER BY r.accomodationID asc,
                r.grade desc;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Ajouter un avis
    function addReview($userID, $accomodationID, $grade, $comment, $date)
    {
        $rqt = "INSERT INTO Review (userID, accomodationID, grade, comment, date) VALUES (:userID, :accomodationID, :grade, :comment, :date);";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':accomodationID', $accomodationID, PDO::PARAM_INT);
        $stmt->bindParam(':grade', $grade, PDO::PARAM_INT);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Avis ajouté!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Avis non ajouté.";
            return false;
        }
    }

    //Supprimer un avis
    function deleteReview($reviewID)
    {
        $rqt = "DELETE FROM Review WHERE reviewID = :reviewID;";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':reviewID', $reviewID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['successMsg'] = "Avis supprimé!";
            return true;
        } else {
            $_SESSION['errorMsg'] = "Avis non supprimé.";
            return false;
        }
    }

    //Modifier un avis
    function modifyReview($column, $value, $reviewId)
    {
        $rqt = "UPDATE Review SET $column = :value WHERE reviewId=:reviewId";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam('value', $value, PDO::PARAM_STR);
        $stmt->bindParam('reviewId', $reviewId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
