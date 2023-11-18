<?php
class ProcessFavoriteController
{

    private $db;
function __construct()
{
    require_once __DIR__ . '/../models/Database.php';
    $this->db = new Database();
}

     function addToFavorite($id)
    {
        $this->db->addToFavorite($id);
        header("Location: /detailsLogement?id=$id");
    }

    function removeFromFavorite($id)
    {
        $this->db->removeFromFavorite($id);
        header("Location: /detailsLogement?id=$id");
    }


    function processFavorite($action, $id){
        $process = new ProcessFavoriteController();
        if($action == "add"){
            $process->addToFavorite($id);
        } elseif($action == "remove"){
            $process->removeFromFavorite($id);
        }
    }
}