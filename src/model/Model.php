<?php

class Model{
    protected $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_exoplanets;charset=utf8', 'root', '');
    }

    public function delete($params){
        try {
            if($params['table'] === 'exoplanets'){
                $str_query = "DELETE FROM exoplanets WHERE id = ?";
            }
            else if ($params['table'] === 'stars'){
                $str_query = "DELETE FROM stars WHERE id = ?";
            }
            else{
                return false;
            }
            $query = $this->db->prepare($str_query);
            $query->execute([$params['id']]);
            return $query->rowCount();
        } catch (Exception) {
            return false;
        }
    }
}