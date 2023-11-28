<?php
class ReviewController
{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }


    function getAvis()
    {
        if (isset($_SESSION['userID'])) {
            require_once __DIR__ . '/../models/Review.php';
            $review = new Review();
            $tabAvisAnnonces = $review->getReviewFromUser();

            echo $this->twig->render('avisView.php', [
                'tabAvisAnnonces' => $tabAvisAnnonces,
            ]);
        } else {
            header('Location: /connection');
        }
    }
}
