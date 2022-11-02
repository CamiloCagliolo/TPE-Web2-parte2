<?php
require_once "src/model/Model.php";

class StarModel extends Model{
    
    public function getAllData(){
        $query = $this->db->prepare('SELECT * FROM stars ORDER BY name ASC');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertNewStar($data){
        try {
            $newStar = [$data->name, $data->mass, $data->methodOrDistance, $data->starOrType];
            $str_query = "INSERT INTO stars (id, name, mass, radius, distance, type) VALUES (NULL, ?, ?, ?, ?, ?)";
            $query = $this->db->prepare($str_query);
            $query->execute($newStar);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function updateStar($data){

        $str_query = "UPDATE stars SET name = ?, mass = ?, radius = ?, 
        distance = ?, type = ? WHERE id = ?";

        $star = [$data->name, $data->mass, $data->radius, $data->methodOrDistance, $data->starOrType, $data->id];

        try {
            $query = $this->db->prepare($str_query);
            $query->execute($star);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function deleteStar($id){
        try {
            $str_query = "DELETE FROM stars WHERE id = ?";
            $query = $this->db->prepare($str_query);
            $query->execute([$id]);
            return true;
        } catch (Exception) {
            return false;
        }
    }
}