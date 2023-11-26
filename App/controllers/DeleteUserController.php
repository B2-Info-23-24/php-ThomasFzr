<?php
class DeleteUserController
{

    public function deleteUser($id)
    {
        if (isset($_SESSION['isAdmin'])) {
            require_once __DIR__ . '/../models/Database.php';
            $db = new Database();
            if ($db->deleteUser($id)) {
                header("Location: /detailsUtilisateur");
            }
        } else {
            header('Location: /');
        }
    }
}
