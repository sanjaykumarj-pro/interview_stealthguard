<?php

class db{

    private $db;
    
    public function __construct(){
        
        $config = require '../config/database.php';
        $this->db=mysqli_connect($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], $config['DB_NAME']);
    }

    public function migrate() {

        try {

            $sql="CREATE TABLE users (id INT AUTO_INCREMENT, username VARCHAR(100), password VARCHAR(100), PRIMARY KEY(id))";
            $this->db->query($sql);
            echo"<br/>Created table, 'users'.";

            $sql="INSERT INTO users (username, password) VALUES('admin', '".md5('12345')."')";
            $this->db->query($sql);
            echo"<br/>Populated 'users' table.";

            $sql="CREATE TABLE uploads (id INT AUTO_INCREMENT, userid VARCHAR(100), filename VARCHAR(100), PRIMARY KEY(id))";
            $this->db->query($sql);
            echo"<br/>Created table, 'uploads'.";

        } catch (Exception $e) {
            echo"<br/>Migration was already run.".$e->getMessage();
        }
    }
}