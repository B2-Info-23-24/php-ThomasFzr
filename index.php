<?php
session_start();

spl_autoload_register(function ($class) {
    include 'App/controllers/' . $class . '.php';
});


require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/App/views');
$twig = new \Twig\Environment($loader);



//creation et remplissage des tables une seule fois au lancement
// $db = new Database();
// if(!$db->createTables()){
//     $db->createTables();
// }
// if(!$db->remplirLogementEquipementService()){
//     $db->remplirLogementEquipementService();
// }

$adresse = $_SERVER['REQUEST_URI'];
// echo $adresse;

$adrExp = explode("?", $adresse);
//Modifier pour passer un / au lieu d'un ?id donc slice peut etre??????????????????????

// echo $adrExp;

$path = $adrExp[0];

switch ($path) {
    case '':
    case '/':
        $controller = new HomeController($twig);
        $controller->loadAnnonce();
        break;
    case '/connection':
        echo $twig->render('connectionView.php');
        break;

    case '/inscription':
        echo $twig->render('inscriptionView.php');
        break;

    case '/detailsLogement':
    case '/detailsLogement/':
        $controller = new DetailsAnnonceController($twig);
        $controller->getDetailsAnnonce($_GET['id']);
        break;

    case '/detailsCompte':
        $controller = new GetInfoUserController($twig);
        $controller->getInfoUser();
        break;

    case '/favoris':
        $controller = new FavoriteController($twig);
        $controller->loadAnnonceFavorite();
        break;

    case '/avis':
        echo $twig->render('avisView.php');
        break;

    case '/reservation':
        echo $twig->render('reservationView.php');
        break;

    case '/process_login':
        $controller = new LoginController();
        $controller->processLogin();
        break;

    case '/process_register':
        $controller = new RegisterController();
        $controller->processRegister();
        break;

    case '/test':
        $controller = new TestController($twig);
        $controller->test();
        break;

    case '/editInfoUser':
        $controller = new EditInfoUserController();
        $controller->processEditInfoUser();
        break;

    case '/deconnection':
        $controller = new DeconnectionController();
        $controller->processDeconnection();
        break;

    default:
        http_response_code(404);
        include 'App/views/404.php';
        echo "case default";
        break;
}
