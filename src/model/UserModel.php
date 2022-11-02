<?php
require_once "src/model/Model.php";

class UserModel extends Model{

    public function getUserData($username){
        $query = $this->db->prepare('SELECT * FROM users WHERE user = ?');
        $query->execute([$username]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insertNewUser($username, $hash){
        try {
            $query = $this->db->prepare('INSERT INTO users (user,password) VALUES (?,?)');
            $query->execute([$username, $hash]);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}