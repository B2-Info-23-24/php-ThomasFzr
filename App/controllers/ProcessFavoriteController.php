<?php
class ProcessFavoriteController
{

    function addToFavorite($id)
    {
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();

        $db->addToFavorite($id);
        header('Location : detailsLogement?id=$id');
    }
}
