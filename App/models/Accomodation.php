<?php
class Accomodation
{

    private $conn;
    function __construct()
    {
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        $this->conn = $db->conn;
    }

    //Récupérer toutes les annonces
    public function getAnnonce($requete)
    {
        $rqt = "SELECT * FROM Annonce $requete";
        $stmt = $this->conn->prepare($rqt);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Récupérer détails d'une annonce
    public function getDetailsAnnonce($annonceID)
    {
        $rqt = "SELECT * FROM Annonce WHERE annonceID = :annonceID";
        $stmt = $this->conn->prepare($rqt);
        $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     //===== ADD ANNONCE =====

     function insertAnnonce($title, $city, $price, $typeLogement, $image)
     {
         $rqt = "INSERT INTO Annonce (title, city, price, typeLogement, image)
           VALUES (:title, :city, :price, :typeLogement, :image);";
         $stmt = $this->conn->prepare($rqt);
         $stmt->bindParam(':title', $title, PDO::PARAM_STR);
         $stmt->bindParam(':city', $city, PDO::PARAM_STR);
         $stmt->bindParam(':price', $price, PDO::PARAM_INT);
         $stmt->bindParam(':typeLogement', $typeLogement, PDO::PARAM_STR);
         $stmt->bindParam(':image', $image, PDO::PARAM_STR);
 
         if ($stmt->execute()) {
             $_SESSION['successMsg'] = "Annonce bien ajoutée!";
             return true;
         } else {
             $_SESSION['errorMsg'] = "Annonce pas ajoutée.";
             return false;
         }
     }
 
     //===== DELETE ANNONCE =====

     function deleteAnnonce($annonceID)
     {
         $rqt = "DELETE FROM ServiceAnnonce WHERE annonceID = :annonceID;
                 DELETE FROM EquipementAnnonce WHERE annonceID = :annonceID;
                 DELETE FROM Favorite WHERE annonceID = :annonceID;
                 DELETE FROM Review WHERE annonceID = :annonceID;
                 DELETE FROM Reservation WHERE annonceID = :annonceID;
                 DELETE FROM Annonce WHERE annonceID = :annonceID;";
         $stmt = $this->conn->prepare($rqt);
         $stmt->bindParam(':annonceID', $annonceID, PDO::PARAM_INT);
         if ($stmt->execute()) {
             $_SESSION['successMsg'] = "Annonce supprimée!";
             return true;
         } else {
             $_SESSION['errorMsg'] = "Annonce non supprimée.";
             return false;
         }
     }
}
