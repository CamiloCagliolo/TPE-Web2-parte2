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

    protected function executeGetAllQuery($sort, $order, $filter, $filterValue, $contains, $str_query, $columns){
                                                                
        if($filter != null && array_key_exists($filter, $columns)){                                   
            $str_query .= "\nWHERE $columns[$filter] LIKE ?";
        }
        else if($filter != null){
            return 400;
        }
                        
        if(array_key_exists($sort, $columns)){                     //LEE SI VINO UN CRITERIO DE ORDEN VÁLIDO Y ASEGURA QUE
            $str_query .= "\nORDER BY $columns[$sort] ";          //QUEDA EN TÉRMINOS DEL ARREGLO ASOCIATIVO DE ARRIBA
        }                                                       //SI SE ENVIÓ UN VALOR INVÁLIDO, ARROJA 400.
        else{
            return 400;
        }

        if(strtoupper($order) == 'ASC' || strtoupper($order) == 'DESC'){    //LEE SI SE ESPECIFICÓ UN ORDEN. SI SE ENVIÓ
            $str_query .= strtoupper($order);                              //UN VALOR DE ORDER INVÁLIDO, ARROJA 400.
        }
        else{
            return 400;
        }

        $query = $this->db->prepare($str_query);

        //CHEQUEA QUE EL FILTRO EXISTA. SI EL FILTRO EXISTE, CHEQUEA EL VALOR DE LA VARIABLE "contains", QUE ES PARA DECIDIR
        //SI EL USUARIO QUIERE FILTRAR POR AQUELLOS ELEMENTOS QUE -CONTENGAN- EL VALOR EN EL ATRIBUTO ESPECIFICADO O, SI NO
        //ESPECIFICA NADA O ESPECIFICA false BUSCARÁ UNA IGUALDAD EXACTA.

        if($filter != null){
            if($contains){
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
}