<?php
require_once "src/model/Model.php";

class StarModel extends Model{
    
    public function getAllData(){
        $query = $this->db->prepare('SELECT * FROM stars ORDER BY name ASC');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert($star){
        try {
            $str_query = "INSERT INTO stars (id, name, mass, radius, distance, type) VALUES (NULL, ?, ?, ?, ?, ?)";
            $query = $this->db->prepare($str_query);
            $query->execute($star);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function update($data){

        $str_query = "UPDATE stars SET name = ?, mass = ?, radius = ?, 
        distance = ?, type = ? WHERE id = ?";

        $star = [$data->name, $data->mass, $data->radius, $data->distance, $data->type, $data->id];

        try {
            $query = $this->db->prepare($str_query);
            $query->execute($star);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function delete($id){
        $params = ['table'=>'stars', 'id'=>$id];
        return parent::delete($params);
    }

    public function getDataById($id){
        $query = $this->db->prepare('SELECT * FROM stars WHERE id = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}