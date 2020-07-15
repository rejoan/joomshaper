<?php

class DBManage {

    private $password;
    private $databaseName;
    private $hostAddress;
    private $userId;

    public function __construct() {
        $this->password = '';
        $this->databaseName = 'joomshaper';
        $this->hostAddress = '127.0.0.1';
        $this->userId = 'root';
    }


    public function connectDatabase() {
        // Create connection
        $mysqli = new mysqli($this->hostAddress, $this->userId, $this->password, $this->databaseName);

// Check connection
        if ($mysqli->connect_error) {
            die('Connection failed: ' . $mysqli->connect_error);
        }
        return $mysqli;
    }

}

?>