<?php

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'home.php';
        break;

    case '/connection':
        require __DIR__ . $viewDir . 'connectionView.php';
        break;

    case '/inscription':
        require __DIR__ . $viewDir . 'inscriptionView.php';
        break;

    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
?>
