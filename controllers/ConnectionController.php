<?php

class ConnectionController {
    public function index() {
        if ($_SESSION['isConnected'] == false) {
            include 'views/connectionView.php';
        } else{
            include 'views/profilUtilisateurView.php';

        }
       
    }
}

?>
