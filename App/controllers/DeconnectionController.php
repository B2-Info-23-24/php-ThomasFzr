<?php
class DeconnectionController
{
    public function processDeconnection()
    {
        session_destroy();
        echo "Deconnexion, au revoir!";
    }
}
?>