<?php

namespace utils;

use PDO;

class DBConnect {
    private $server = 'eu-cdbr-west-02.cleardb.net';
    private $dbName = 'heroku_38e7e52b0cddcf3';
    private $user = 'b82a7c14965f0f';
    private $password = 'f0444414';

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