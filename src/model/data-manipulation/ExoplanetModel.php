<?php
require_once "src/model/data-manipulation/Model.php";

class ExoplanetModel extends Model{

    public function getAllData($sort, $order, $filter, $filterValue, $contains){
        $str_query = 'SELECT e.id, e.name, e.mass, e.radius, m.name_acronym as method, s.name as star 
        FROM exoplanets e 
        INNER JOIN methods m ON e.id_method = m.id 
        INNER JOIN stars s ON e.id_star = s.id';

        $columns = array('name' => 'e.name ', 
                        'mass' => 'e.mass ', 
                        'radius' => 'e.radius ',
                        'method' => 'm.name_acronym ',
                        'star' => 's.name ');


        return parent::executeGetAllQuery($sort, $order, $filter, $filterValue, $contains, $str_query, $columns);
    }

    public function insert($exoplanet){
        try {
            $exoplanet[3] = $this->getIdMethodByName($exoplanet[3]);
            $exoplanet[4] = $this->getIdStarByName($exoplanet[4]);

            $str_query = "INSERT INTO exoplanets (id, name, mass, radius, id_method, id_star) VALUES (NULL, ?, ?, ?, ?, ?)";
            $query = $this->db->prepare($str_query);
            $query->execute($exoplanet);
            return true;
            
        } catch (Exception) {
            return false;
        }
    }

    public function update($data){

        $idMethod = $this->getIdMethodByName($data->method);
        $idStar = $this->getIdStarByName($data->star);

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

    public function delete($id){
        $params = ['table'=>'exoplanets', 'id'=>$id];
        return parent::delete($params);
    }

    public function getDataById($id){
        $query = $this->db->prepare('SELECT e.id, e.name, e.mass, e.radius, m.name_acronym as method, s.name as star 
                                    FROM exoplanets e 
                                    INNER JOIN methods m ON e.id_method = m.id 
                                    INNER JOIN stars s ON e.id_star = s.id
                                    WHERE e.id = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    
    private function getIdMethodByName($name)
    {
        try {
            $query = $this->db->prepare('SELECT id FROM methods WHERE name_acronym = ?');
            $query->execute([$name]);
            $id = @$query->fetch(PDO::FETCH_OBJ)->id;
            return $id;
        } catch (Exception) {
            return null;
        }
    }

    private function getIdStarByName($name)
    {
        try {
            $query = $this->db->prepare('SELECT id FROM stars WHERE name = ?');
            $query->execute([$name]);
            $id = @$query->fetch(PDO::FETCH_OBJ)->id;
            return $id;
        } catch (Exception) {
            return null;
        }
    }
}