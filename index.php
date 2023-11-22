<?php
session_start();

require_once 'vendor/autoload.php';


spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    $baseDir = __DIR__ . '/App/controllers/';
    $filePath = $baseDir . $file;
    if (file_exists($filePath)) {
        include $filePath;
    }
});

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/App/views');
$twig = new \Twig\Environment($loader);


require_once __DIR__ . '/App/models/Database.php';
$database = new Database();
if ($database->createTables()) {
    $database->remplirLogementEquipementService();
    $database->insertFakerDatas();
    $database->remplirEquipemmentAnnonceEtServiceAnnonce();
}



if (isset($_SESSION['userID'])) {
    $isConnected = true;
    $twig->addGlobal('isConnected', $isConnected);
}

if (isset($_SESSION['surname'])) {
    $surname = $_SESSION['surname'];
    $twig->addGlobal('surname', $surname);
}

if (isset($_SESSION['successMsg'])) {
    $successMsg = $_SESSION['successMsg'];
    $twig->addGlobal('successMsg', $successMsg);
    unset($_SESSION['successMsg']);
}

if (isset($_SESSION['errorMsg'])) {
    $errorMsg = $_SESSION['errorMsg'];
    $twig->addGlobal('errorMsg', $errorMsg);
    unset($_SESSION['errorMsg']); // Clear the errorMsg
}


$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', trim($urlPath, '/'));
$route = "/" . $parts[0];
$id = $parts[1] ?? null;

// echo "Route: $route, ID: $id";

switch ($route) {
    case '':
    case '/':
        $controller = new HomeController($twig);
        $typeLogement = isset($_GET['typeLogement']) ? $_GET['typeLogement'] : '';
        $ville = isset($_GET['ville']) ? $_GET['ville'] : '';
        $selectedEquipements = isset($_GET['selectedEquipements']) ? $_GET['selectedEquipements'] : [];
        $selectedServices = isset($_GET['selectedServices']) ? $_GET['selectedServices'] : [];
        $controller->getInfoHome($typeLogement, $selectedEquipements, $selectedServices, $ville);
        break;

    case '/connection':
        echo $twig->render('connectionView.php');
        break;

    case '/inscription':
        echo $twig->render('inscriptionView.php');
        break;

    case '/detailsLogement':
        $controller = new DetailsAnnonceController($twig);
        $controller->getDetailsAnnonce($id);
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
        $controller = new ReservationController($twig);
        $controller->getReservation();
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

    case '/process_avis':
        $controller = new ProcessAvisController();
        $controller->insertAvis($_GET['id']);
        break;

    case '/process_reservation':
        $controller = new ProcessReservationController();
        $controller->insertReservation($_GET['id']);
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
        break;
}
