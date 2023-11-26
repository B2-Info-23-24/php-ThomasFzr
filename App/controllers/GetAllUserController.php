<?php
class GetAllUserController
{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function getAllUser()
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Database.php';
            $db = new Database();
            $users = $db->getAllUser();

            echo $this->twig->render(
                'allUserView.php',
                [
                    'users' => $users,
                ]
            );
        } else {
            header('Location: /');
        }
    }
}
