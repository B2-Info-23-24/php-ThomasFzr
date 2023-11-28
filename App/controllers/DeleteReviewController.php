<?php
class DeleteReviewController
{
    public function deleteReview($id)
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Review.php';
            $review = new Review();
            if ($review->deleteReview($id)) {
                header("Location: /allReviews");
            }
        } else {
            header('Location: /');
        }
    }
}
