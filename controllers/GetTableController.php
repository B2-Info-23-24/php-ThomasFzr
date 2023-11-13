<?php
class GetTableController
{
    public function processGetTable()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo 'je passe dans processGetTable <br/>';
            require_once __DIR__ . '/../models/db_connect.php';
            $database = new Database();
            $database->getConnection();
            $database->getTable();
        } else{
            echo 'function getTable je ne suis pas un Get <br/>';
        }
    }
}
