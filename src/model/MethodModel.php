<?php
require_once "src/model/Model.php";

class MethodModel extends Model{

    public function getMethods(){
        $query = $this->db->prepare('SELECT * FROM methods');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}