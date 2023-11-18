<?php
session_start();

require_once 'vendor/autoload.php';

// Assuming your classes follow PSR-4 naming conventions
spl_autoload_register(function ($class) {
    // Convert class name to file path
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    // Define the base directory for your classes
    $baseDir = __DIR__ . '/App/controllers/';

    // Construct the full path to the class file
    $filePath = $baseDir . $file;

    // Include the class file if it exists
    if (file_exists($filePath)) {
        include $filePath;
    }
});


// use 'App/controllers/DeconnectionController.php';
// include 'App/controllers/DetailsAnnonce.php';
// include 'App/controllers/DeconnectionController.php';
// include 'App/controllers/DeconnectionController.php';
// include 'App/controllers/DeconnectionController.php';
// include 'App/controllers/DeconnectionController.php';
// include 'App/controllers/DeconnectionController.php';
// include 'App/controllers/DeconnectionController.php';
// include 'App/controllers/DeconnectionController.php';


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
        $controller = new AvisController($twig);
        $controller->getAvis();
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

    case '/process_favorite':
        $controller = new ProcessFavoriteController();
        $controller->processFavorite($_GET['action'], $_GET['id']);
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
