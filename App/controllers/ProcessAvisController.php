<?php
class ProcessAvisController
{


    public function insertAvis($annonceID)
    {
        if (isset($_SESSION['userID'])) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                require_once __DIR__ . '/../models/Review.php';
                $review = new Review();

                $date = new DateTime('now');
                $date = $date->format('Y-m-d');

                $review->insertReview($annonceID,  $_POST["grade"], $_POST["comment"], $date);
                header("Location: /detailsLogement/$annonceID");
            }
        } else {
            header('Location: /connection');
        }
    }
}
