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

if (isset($_SESSION['userID'])) {
    $isConnected = true;
    $twig->addGlobal('isConnected', $isConnected);
}

if (isset($_SESSION['surname'])) {
    $surname = $_SESSION['surname'];
    $twig->addGlobal('surname', $surname);
}

if (isset($_SESSION['isAdmin'])) {
    $isAdmin = $_SESSION['isAdmin'];
    $twig->addGlobal('isAdmin', $isAdmin);
}

if (isset($_SESSION['successMsg'])) {
    $successMsg = $_SESSION['successMsg'];
    $twig->addGlobal('successMsg', $successMsg);
    unset($_SESSION['successMsg']);
}

if (isset($_SESSION['errorMsg'])) {
    $errorMsg = $_SESSION['errorMsg'];
    $twig->addGlobal('errorMsg', $errorMsg);
    unset($_SESSION['errorMsg']);
}

if (isset($_GET['accomodationType'])) {
    $accomodationType = $_GET['accomodationType'];
    $twig->addGlobal('accomodationType', $accomodationType);
} else {
    $accomodationType = '';
    $twig->addGlobal('accomodationType', $accomodationType);
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
        $accomodationType = isset($_GET['accomodationType']) ? $_GET['accomodationType'] : '';
        $accomodationTitle = isset($_GET['accomodationTitle']) ? $_GET['accomodationTitle'] : '';
        $ville = isset($_GET['city']) ? $_GET['city'] : '';
        $minPrice = isset($_GET['min-price']) ? $_GET['min-price'] : '';
        $maxPrice = isset($_GET['max-price']) ? $_GET['max-price'] : '';
        $selectedEquipments = isset($_GET['selectedEquipments']) ? $_GET['selectedEquipments'] : [];
        $selectedServices = isset($_GET['selectedServices']) ? $_GET['selectedServices'] : [];
        $controller->getInfoHome($accomodationType, $selectedEquipments, $selectedServices, $ville, $minPrice, $maxPrice, $accomodationTitle);

        break;

    case '/connection':
        echo $twig->render('connectionView.php');
        break;

    case '/inscription':
        echo $twig->render('registerView.php');
        break;

    case '/accomodation':
        $controller = new DetailsAccomodationController($twig);
        $controller->getDetailsAccomodation($id);
        break;

    case '/myAccount':
        $controller = new GetInfoUserController($twig);
        $controller->getInfoUser();
        break;

    case '/myFavorites':
        $controller = new FavoriteController($twig);
        $controller->loadAccomodationFavorite();
        break;

    case '/myReviews':
        $controller = new ReviewController($twig);
        $controller->getReview();
        break;

    case '/myReservations':
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

    case '/process_review':
        $controller = new ProcessReviewController();
        $controller->insertAvis($_GET['id']);
        break;

    case '/process_reservation':
        $controller = new ProcessReservationController();
        $controller->insertReservation($_GET['id']);
        break;

        //TODO supprimer
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

    case '/addAccomodation':
        $controller = new AddAnnonceController($twig);
        $controller->addAnnonce();
        break;

    case '/processAccomodation':
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $controller = new ProcessAccomodationController();
        $controller->processAccomodation($_GET['action'], $id);
        break;

    case '/allUsers':
        $controller = new GetAllUserController($twig);
        $controller->getAllUser();
        break;

    case '/processUser':
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $controller = new ProcessUserController();
        $controller->processUser($_GET['action'], $id);
        break;

    case '/allReviews':
        $controller = new GetAllReviewController($twig);
        $controller->getAllReview();
        break;

    case '/deleteReview':
        $controller = new DeleteReviewController();
        $controller->deleteReview($_GET['id']);
        break;

    case '/detailsEquipmentServiceAccomodationType':
        $controller = new DetailsEquipmentServiceAccomodationTypeController($twig);
        $controller->getTypesLogementEquipementsServices();
        break;

    case '/processAccomodationType':
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $controller = new ProcessAccomodationTypeController();
        $controller->processAccomodationType($_GET['action'], $id);
        break;

    case '/processService':
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $controller = new ProcessServiceController();
        $controller->processService($_GET['action'], $id);
        break;

    case '/processEquipment':
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $controller = new ProcessEquipmentController();
        $controller->processEquipment($_GET['action'], $id);
        break;

    default:
        http_response_code(404);
        include 'App/views/404.php';
        break;
}
