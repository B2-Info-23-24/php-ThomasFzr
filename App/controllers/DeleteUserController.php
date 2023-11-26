<?php
class DeleteUserController{

    public function deleteUser($id){
        require_once __DIR__ . '/../models/Database.php';
        $db = new Database();
        if ($db->deleteUser($id)) {
            header("Location: /detailsUtilisateur");
        }
    }
}