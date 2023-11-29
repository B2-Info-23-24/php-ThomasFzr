<?php
class addUniqueReviewController
{
    public function addReview($accomodationID)
    {
        if (isset($_SESSION['userID'])) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                require_once __DIR__ . '/../models/Review.php';
                $review = new Review();

                $date = new DateTime('now');
                $date = $date->format('Y-m-d');

                $review->insertReview($accomodationID,  $_POST["grade"], $_POST["comment"], $date);
                header("Location: /detailsLogement/$accomodationID");
            }
        } else {
            header('Location: /connection');
        }
    }
}
