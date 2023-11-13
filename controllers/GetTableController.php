<?php
class GetTableController
{
    public function processGetTable()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo 'je passe dans le if de processGetTable <br/>';
            require_once __DIR__ . '/../models/db_connect.php';
            $database = new Database();
            // $database->createTable();
            $database->createTables();
        } else {
            echo 'function getTable je ne suis pas un POST <br/>';
        }
    }
}

// phpinfo();