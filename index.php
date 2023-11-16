<?php
session_start();

spl_autoload_register(function ($class) {
    include 'App/controllers/' . $class . '.php';
});


require_once 'vendor/autoload.php';

//rendu
$loader = new Twig_Loader_Filesystem([__DIR__ . '/App/views']);
$twig = new Twig_Environment($loader, [
    'cache' => false
    // __DIR__ . '/tmp'
]);

echo $twig->render('headerView.php');

if (isset($_GET["page"])) {
    $page = $_GET["page"];

    switch ($page) {
        case '':
        case '/':
            echo $twig->render('home.php');
            break;

        case 'connection':
            echo $twig->render('connectionView.php');
            break;

        case 'inscription':
            echo $twig->render('inscriptionView.php');
            break;

        case 'detailsLogement':
            echo $twig->render('detailsLogementView.php');
            break;

        case 'detailsCompte':
            echo $twig->render('detailsCompteView.php');
            break;

        case 'favoris':
            echo $twig->render('favorisView.php');
            break;

        case 'avis':
            echo $twig->render('avisView.php');
            break;

        case 'reservation':
            echo $twig->render('reservationView.php');
            break;

        case 'process_login':
            $controller = new LoginController();
            $controller->processLogin();
            break;

        case 'process_register':
            $controller = new RegisterController();
            $controller->processRegister();
            break;

        case 'test':
            $controller = new TestController();
            $controller->test();
            break;

        case 'editInfoUser':
            $controller = new EditInfoUserController();
            $controller->processEditInfoUser();
            break;

        case 'deconnection':
            $controller = new DeconnectionController();
            $controller->processDeconnection();
            break;

        default:
            http_response_code(404);
            include 'App/views/404.php';
            break;
    }
} else {
    echo $twig->render('home.php');
}
