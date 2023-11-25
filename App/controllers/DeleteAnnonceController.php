<?php
class deleteAnnonceController
{
    function deleteAnnonce($id)
    {
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        if ($db->deleteAnnonce($id)) {
            header("Location: /");
        } else {
            header("Location: /detailsLogement/$id");
        }
    }
}
