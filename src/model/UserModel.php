<?php

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_exoplanets;charset=utf8', 'root', '');
    }

    public function getUserData($username)
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE user = ?');
        $query->execute([$username]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insertNewUser($username, $hash)
    {
        try {
            $query = $this->db->prepare('INSERT INTO users (user,password) VALUES (?,?)');
            $query->execute([$username, $hash]);
            return true;
        } catch (Exception) {
            return false;
        }
    }
}
