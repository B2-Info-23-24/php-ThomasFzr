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
            require_once __DIR__ . '/../models/User.php';
            require_once __DIR__ . '/../models/Accommodation.php';
            $review = new Review();
            $user = new User();
            $accommodation = new Accommodation();

            $reviews = $review->getAllReview();
            $users = $user->getAllUser();
            $accommodations = $accommodation->getAccommodation(''); 

            echo $this->twig->render(
                'allReviewView.php',
                [
                    'reviews' => $reviews,
                    'users' => $users,
                    'accommodations' => $accommodations
                ]
            );
        } else {
            header('Location: /connection');
        }
    }
}
