<?php

class DatabaseConnection
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $pdo;

    public function __construct($host, $dbname, $username, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;

         // Set the default time zone
         date_default_timezone_set('Africa/Accra');
    }

    public function connect()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
            return $this->pdo;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}
