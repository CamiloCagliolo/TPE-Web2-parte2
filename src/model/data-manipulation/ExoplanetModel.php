<?php
require_once "src/model/Model.php";

class ExoplanetModel extends Model{

    public function getAllData($sort = 'name', $order = 'ASC'){
        $str_query = 'SELECT e.id, e.name, e.mass, e.radius, m.name_acronym as method, s.name as star 
        FROM exoplanets e 
        INNER JOIN methods m ON e.id_method = m.id 
        INNER JOIN stars s ON e.id_star = s.id';

        $columns = array('name' => 'e.name ', 
                        'mass' => 'e.mass ', 
                        'radius' => 'e.radius ',
                        'method' => 'm.name_acronym ',
                        'star' => 's.name ');

        $filter = $this->readFilter();                           //LEE SI VINO UN FILTRO VÁLIDO Y ASEGURA QUE QUEDA EN 
        if($filter != null){                                    //TÉRMINOS DEL ARREGLO ASOCIATIVO DE MÁS ARRIBA
            $str_query .= "\nWHERE $columns[$filter] LIKE ?";
            $filterValue = $_GET[$filter];
        }

        if(isset($columns[$sort])){                             //LEE SI VINO UN CRITERIO DE ORDEN VÁLIDO Y ASEGURA QUE
            $str_query .=  "\nORDER BY $columns[$sort] ";       //QUEDA EN TÉRMINOS DEL ARREGLO ASOCIATIVO DE ARRIBA
        }                                                       //SI SE ENVIÓ UN VALOR INVÁLIDO ARROJA 404.
        else{
            return null;
        }

        if(strtoupper($order) == 'ASC' || strtoupper($order) == 'DESC'){   //LEE SI SE ESPECIFICÓ UN ORDEN. SI SE ENVIÓ
            $str_query .= strtoupper($order);                              //UN VALOR DE ORDER INVÁLIDO, ARROJA NULL -> 404.
        }
        else{
            return null;
        }

        $query = $this->db->prepare($str_query);

        //CHEQUEA QUE EL FILTRO EXISTA. SI EL FILTRO EXISTE, CHEQUEA EL VALOR DE LA VARIABLE "contains", QUE ES PARA DECIDIR
        //SI EL USUARIO QUIERE FILTRAR POR AQUELLOS ELEMENTOS QUE -CONTENGAN- EL VALOR EN EL ATRIBUTO ESPECIFICADO O, SI NO
        //ESPECIFICA NADA O ESPECIFICA false BUSCARÁ UNA IGUALDAD EXACTA.

        if($filter != null){
            if(isset($_GET["contains"]) && strtolower($_GET["contains"]) == 'true'){
                $query->execute(["%".$filterValue."%"]);
            }
            else if(isset($_GET["contains"]) && strtolower($_GET["contains"]) != 'false'){
                return null;
            }
            else{
                $query->execute([$filterValue]);
            }                          
        }
        else{
            $query->execute();                                          
        }

        return $query->fetchAll(PDO::FETCH_OBJ);
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

    private function readFilter(){
        $possibleFilters = ["name", "mass", "radius", "method", "star"];
        foreach($possibleFilters as $filter){
            if(isset($_GET[$filter])){
                return $filter;
            }
        }
        return null;
    }
}