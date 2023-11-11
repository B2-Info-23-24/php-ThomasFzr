<?php
class GetTableController
{
    public function processGetTable()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            require_once __DIR__ . '/../models/db_connect.php';
            $database = new Database();
            $database->getConnection();
            $database->getTable();
        }
    }
}
