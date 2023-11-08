<?php

// require_once "views/home.php";
// if (isset($_GET["page"])){
//     switch ($_GET["page"]) {
//     case '/':
//         include "views/home.php";
//         break;

//     case 'connection':
//         include 'views/connectionView.php';
//         break;

//     case 'inscription':
//         include 'views/inscriptionView.php';
//         break;

//     default:
//         http_response_code(404);
//         include 'views/404.php';
//     }
// }

?>

<?php

spl_autoload_register(function ($class) {
    include 'controllers/' . $class . '.php';
});


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

        default:
            http_response_code(404);
            include 'views/404.php';
            break;
    }
} else {
    // Default to home if no specific page is requested
    $controller = new HomeController();
    $controller->index();
}
?>
