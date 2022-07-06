<?php

namespace utils;

use PDO;

class DBConnect {
    private $server;
    private $dbName;
    private $user;
    private $password;

    public function __construct()
    {
        $this->server = $_ENV['SERVER'];
        $this->dbName = $_ENV['DB_NAME'];
        $this->user = $_ENV['USERNAME'];
        $this->password = $_ENV['PASSWORD'];
    }

    public function connect() {
        try {
            $conn = new PDO('mysql:host=' .$this->server .';dbname=' . $this->dbName, $this->user, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\Exception $e) {
            return "Database Error: " . $e->getMessage();
        }
    }
}