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
            $accommodationID = $_POST['accommodationID'];
            $grade = $_POST['grade'];
            $comment = $_POST['comment'];
            $date = $_POST['date'];
            if ($this->review->addReview($userID, $accommodationID, $grade, $comment, $date)) {
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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $successMsg = "";

            if (isset($_POST["userID"]) && $_POST["userID"] != '') {
                $this->review->modifyReview('userID', $_POST['userID'], $reviewId);
                $successMsg = "Utilisateur";
            }
            if (isset($_POST["grade"]) && $_POST["grade"] != '') {
                $this->review->modifyReview('grade', $_POST['grade'], $reviewId);
                $successMsg = $successMsg . " Note";
            }
            if (isset($_POST["comment"]) && $_POST["comment"] != '') {
                $this->review->modifyReview('comment', $_POST['comment'], $reviewId);
                $successMsg = $successMsg . " Commentaire";
            }
            if (isset($_POST["date"]) && $_POST["date"] != '') {
                $this->review->modifyReview('date', $_POST['date'], $reviewId);
                $successMsg = $successMsg . " Date";
            }

            if ((isset($_POST["userID"]) && $_POST["userID"] != '') || (isset($_POST["grade"]) && $_POST["grade"] != '')
                || (isset($_POST["comment"]) && $_POST["comment"] != '') || (isset($_POST["Date"]) && $_POST["Date"] != '')
            ) {
                $_SESSION['successMsg'] = $successMsg . " changé avec succès";
            }

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
