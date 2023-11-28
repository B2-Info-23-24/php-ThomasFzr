<?php
class GetAllReviewController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function getAllReview()
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Review.php';
            $review = new Review();
            $reviews = $review->getAllReview();

            echo $this->twig->render(
                'allReviewView.php',
                [
                    'reviews' => $reviews,
                ]
            );
        } else {
            header('Location: /');
        }
    }
}
