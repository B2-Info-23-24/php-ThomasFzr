<?php
class ProcessReviewController
{

    private $review;
    function __construct()
    {
        require_once __DIR__ . '/../models/Review.php';
        $this->review = new Review();
    }

    public function addReview()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userID = $_POST['userID'];
            $accomodationID = $_POST['accomodationID'];
            $grade = $_POST['grade'];
            $comment = $_POST['comment'];
            $date = $_POST['date'];
            if ($this->review->addReview($userID, $accomodationID, $grade, $comment, $date)) {
                header('Location: /allReviews');
            }
        }
    }

    public function deleteReview($reviewId)
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Review.php';
            $review = new Review();
            if ($review->deleteReview($reviewId)) {
                header("Location: /allReviews");
            }
        } else {
            header('Location: /');
        }
    }

    function modifyReview($reviewId)
    {
        $userID = $_POST['userID'];
        $accomodationID = $_POST['accomodationID'];
        $grade = $_POST['grade'];
        $comment = $_POST['comment'];
        $date = $_POST['date'];
        if ($this->review->modifyReview($userID, $accomodationID, $grade, $comment, $date, $reviewId)) {
            header("Location: /allReviews");
        }
    }


    function processReview($action, $id)
    {
        if (isset($_SESSION['isAdmin'])) {
            $process = new ProcessReviewController();
            if ($action == "add") {
                $process->addReview();
            } elseif ($action == "delete") {
                $process->deleteReview($id);
            } elseif ($action == "modify") {
                $process->modifyReview($id);
            }
        } else {
            header('Location: /connection');
        }
    }
}
