<?php

class ConnectionController {
    public function index() {
        if (isset($_SESSION['isConnected']) && $_SESSION['isConnected'] == true) {
            include 'views/profilUtilisateurView.php';
        } else{
            include 'views/connectionView.php';
        }
    }
}
?>
