<?php
require_once "src/model/Model.php";

class StarModel extends Model{
    
    public function getAllData($sort = 'name', $order = 'ASC'){
        $str_query = 'SELECT * FROM stars';

        $columns = array('name' => 'name ', 
                        'mass' => 'mass ', 
                        'radius' => 'radius ',
                        'distance' => 'distance ',
                        'type' => 'type ');

        $filter = $this->readFilter();                           //LEE SI VINO UN FILTRO VÁLIDO Y ASEGURA QUE QUEDA EN 
        if($filter != null){                                    //TÉRMINOS DEL ARREGLO ASOCIATIVO DE MÁS ARRIBA
            $str_query .= "\nWHERE $columns[$filter] LIKE ?";
            $filterValue = $_GET[$filter];
        }
                        
        if(isset($columns[$sort])){                             //LEE SI VINO UN CRITERIO DE ORDEN VÁLIDO Y ASEGURA QUE
            $str_query .= " ORDER BY $columns[$sort]";          //QUEDA EN TÉRMINOS DEL ARREGLO ASOCIATIVO DE ARRIBA
        }                                                       //SI SE ENVIÓ UN VALOR INVÁLIDO ARROJA 404.
        else{
            return null;
        }

        if(strtoupper($order) == 'ASC' || strtoupper($order) == 'DESC'){    //LEE SI SE ESPECIFICÓ UN ORDEN. SI SE ENVIÓ
            $str_query .= $order;                                           //UN VALOR DE ORDER INVÁLIDO, ARROJA NULL -> 404.
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
            else{
                $query->execute([$filterValue]);
            }                          
        }
        else{
            $query->execute();                                          
        }

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

    private function readFilter(){
        $possibleFilters = ["name", "mass", "radius", "distance", "type"];
        foreach($possibleFilters as $filter){
            if(isset($_GET[$filter])){
                return $filter;
            }
        }
        return null;
    }
}