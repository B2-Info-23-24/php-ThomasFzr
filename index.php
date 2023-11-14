<?php
session_start();

spl_autoload_register(function ($class) {
    include 'App/controllers/' . $class . '.php';
});

include "App/views/headerView.php";

if (isset($_GET["page"])) {
    $page = $_GET["page"];

    switch ($page) {
        case '':
        case '/':
            $controller = new HomeController();
            $controller->index();
            break;

        case 'connection':
            $controller = new ConnectionController();
            $controller->index();
            break;

        case 'inscription':
            $controller = new InscriptionController();
            $controller->index();
            break;

        case 'deconnection':
            $controller = new DeconnectionController();
            $controller->processDeconnection();
            break;

        case 'detailsLogement':
            $controller = new DetailsLogementController();
            $controller->index();
            break;

        case 'detailsCompte':
            $controller = new DetailsCompteController();
            $controller->index();
            break;

        case 'favoris':
            $controller = new FavorisController();
            $controller->index();
            break;

        case 'avis':
            $controller = new AvisController();
            $controller->index();
            break;

        case 'reservation':
            $controller = new ReservationController();
            $controller->index();
            break;

        case 'process_login':
            $controller = new LoginController();
            $controller->processLogin();
            break;

        case 'process_register':
            $controller = new RegisterController();
            $controller->processRegister();
            break;

        case 'process_getTable':
            $controller = new GetTableController();
            $controller->processGetTable();
            break;

        default:
            http_response_code(404);
            include 'App/views/404.php';
            break;
    }
} else {
    $controller = new HomeController();
    $controller->index();
}
