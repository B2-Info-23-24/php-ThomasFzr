<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


class Database
{
    private $host = 'localhost';
    // '172.17.61.133';
    private $dbname = 'my_database';
    private $username = 'my_user';
    private $password = 'my_password';
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Connection failed (func construct): " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        try {
            return $this->conn;
        } catch (PDOException $e) {
            die("Connection failed (func getConnection): " . $e->getMessage());
        }
    }


    public function getTable()
    {
        try {
            $data = $this->conn->query("SELECT * FROM User")->fetchAll();
            // and somewhere later:
            foreach ($data as $row) {
                echo $row['name'] . "<br />\n";
            }

            echo 'Succès !';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function createTable()
    {
        try {
            $sql = "CREATE TABLE Test(
                Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                Nom VARCHAR(30) NOT NULL,
                Prenom VARCHAR(30) NOT NULL,
                Adresse VARCHAR(70) NOT NULL,
                Mail VARCHAR(50) NOT NULL,
                DateInscription TIMESTAMP,
                UNIQUE(Mail))";

            $this->conn->exec($sql);
            echo 'Table bien créée !';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}


// phpinfo();
