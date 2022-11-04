<?php

abstract class Model{
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

    protected function executeGetAllQuery($sort, $order, $str_query, $columns){

        $filter = $this->readFilter();                           //LEE SI VINO UN FILTRO VÁLIDO Y ASEGURA QUE QUEDA EN 
        if($filter != null){                                    //TÉRMINOS DEL ARREGLO ASOCIATIVO DE MÁS ARRIBA
            $str_query .= "\nWHERE $columns[$filter] LIKE ?";
            $filterValue = $_GET[$filter];
        }
                        
        if(array_key_exists($sort, $columns)){                     //LEE SI VINO UN CRITERIO DE ORDEN VÁLIDO Y ASEGURA QUE
            $str_query .= "\nORDER BY $columns[$sort] ";          //QUEDA EN TÉRMINOS DEL ARREGLO ASOCIATIVO DE ARRIBA
        }                                                       //SI SE ENVIÓ UN VALOR INVÁLIDO ARROJA 404.
        else{
            return null;
        }

        if(strtoupper($order) == 'ASC' || strtoupper($order) == 'DESC'){    //LEE SI SE ESPECIFICÓ UN ORDEN. SI SE ENVIÓ
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

    public abstract function readFilter();
}