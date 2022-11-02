<?php
require_once "src/model/Model.php";

class ExoplanetModel extends Model{

    public function getAllData(){
        $query = $this->db->prepare('SELECT e.*, m.name_acronym, s.name as star_name FROM exoplanets e 
                                    INNER JOIN methods m ON e.id_method = m.id 
                                    INNER JOIN stars s ON e.id_star = s.id
                                    ORDER BY e.name ASC');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertExoplanet($data){
        try {
            $id_method = $this->getIdMethodByName($data->methodOrDistance);
            $id_star = $this->getIdStarByName($data->starOrType);

            $newExoplanet = [$data->id, $data->name, $data->radius, $data->mass, $id_method, $id_star];

            $str_query = "INSERT INTO exoplanets (id, name, mass, radius, id_method, id_star) VALUES (NULL, ?, ?, ?, ?, ?)";
            $query = $this->db->prepare($str_query);
            $query->execute($newExoplanet);

            return true;
        } catch (Exception) {
            return false;
        }
    }

    public function updateExoplanet($data){

        $idMethod = $this->getIdMethodByName($data->methodOrDistance);
        $idStar = $this->getIdStarByName($data->starOrType);

        $str_query = "UPDATE exoplanets SET name = ?, mass = ?, radius = ?, 
        id_method = ?, id_star = ? WHERE id = ?";

        $exoplanet = [$data->name, $data->mass, $data->radius, $idMethod, $idStar, $data->id];

        try {
            $query = $this->db->prepare($str_query);
            $query->execute($exoplanet);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function deleteExoplanet($id)
    {
        try {
            $str_query = "DELETE FROM exoplanets WHERE id = ?";
            $query = $this->db->prepare($str_query);
            $query->execute([$id]);
            return true;
        } catch (Exception) {
            return false;
        }
    }
    
    private function getIdMethodByName($name)
    {
        try {
            $query = $this->db->prepare('SELECT id FROM methods WHERE name_acronym = ?');
            $query->execute([$name]);
            $id = $query->fetch(PDO::FETCH_OBJ)->id;
            return $id;
        } catch (Exception $ex) {
            return null;
        }
    }

    private function getIdStarByName($name)
    {
        try {
            $query = $this->db->prepare('SELECT id FROM stars WHERE name = ?');
            $query->execute([$name]);
            $id = $query->fetch(PDO::FETCH_OBJ)->id;
            return $id;
        } catch (Exception $ex) {
            return null;
        }
    }

}