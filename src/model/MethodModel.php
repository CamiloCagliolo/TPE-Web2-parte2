<?php

class MethodModel{
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_exoplanets;charset=utf8', 'root', '');
    }

    public function getMethods(){
        $query = $this->db->prepare('SELECT * FROM methods');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}