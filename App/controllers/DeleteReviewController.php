<?php
class DeleteReviewController
{
    public function deleteReview($id)
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Database.php';
            $db = new Database();
            if ($db->deleteReview($id)) {
                header("Location: /detailsAvis");
            }
        } else {
            header('Location: /');
        }
    }
}
