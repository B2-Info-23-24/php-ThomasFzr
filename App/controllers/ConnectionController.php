<?php

class ConnectionController {
    public function index() {
        if (isset($_SESSION['isConnected']) && $_SESSION['isConnected'] == true) {
            include 'App/views/profilUtilisateurView.php';
        } else{
            include 'App/views/connectionView.php';
        }
    }
}
?>
