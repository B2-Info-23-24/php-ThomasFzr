<?php
class GetInfoUserController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function getInfoUser()
    {
        require_once __DIR__ . '/../models/Database.php';
        $database = new Database();

        $infoUser = $database->getUserInfo($_SESSION['mail']);
        echo $this->twig->render('detailsCompteView.php', ['infoUser' => $infoUser]);
    }
}
