<?php
class ReviewController
{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }


    function getReview()
    {
        if (isset($_SESSION['userID'])) {
            require_once __DIR__ . '/../models/Review.php';
            $review = new Review();
            $tabReviewAccomodations = $review->getReviewFromUser();

            echo $this->twig->render('reviewView.php', [
                'tabReviewAccomodations' => $tabReviewAccomodations,
            ]);
        } else {
            header('Location: /connection');
        }
    }
}
