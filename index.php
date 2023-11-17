<?php
session_start();

spl_autoload_register(function ($class) {
    include 'App/controllers/' . $class . '.php';
});


require_once 'vendor/autoload.php';


$loader = new Twig_Loader_Filesystem([__DIR__ . '/App/views']);
$twig = new Twig_Environment($loader, [
    'cache' => false
]);


if (isset($_GET["page"])) {
    $page = $_GET["page"];

    switch ($page) {
        case 'connection':
            echo $twig->render('connectionView.php');
            break;

        case 'inscription':
            echo $twig->render('inscriptionView.php');
            break;

        case 'detailsLogement':
            if (isset($_GET['annonceID'])) {
                $controller = new DetailsAnnonceController($twig);
                $controller->getDetailsAnnonce($_GET['annonceID']);
            } else {
                // Handle the case where 'annonceID' is not set
                echo "Error: 'annonceID' is not provided in the URL.";
            }
            break;

        case 'detailsCompte':
            $controller = new GetInfoUserController($twig);
            $controller->getInfoUser();
            break;

        case 'favoris':
            $controller = new FavoriteController($twig);
            $controller->loadAnnonceFavorite();
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
            $controller = new TestController($twig);
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
    $controller = new HomeController($twig);
    $controller->loadAnnonce();
}
