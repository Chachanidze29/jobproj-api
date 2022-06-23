<?php

namespace utils;

use PDO;

class DBConnect {
    private $server = 'localhost';
    private $dbName = 'scandiweb-db';
    private $user = 'root';
    private $password = '';

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