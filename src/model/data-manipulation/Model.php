<?php

abstract class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_exoplanets;charset=utf8', 'root', '');
    }

    public function delete($params)
    {
        try {
            if ($params['table'] === 'exoplanets') {
                $str_query = "DELETE FROM exoplanets WHERE id = ?";
            } else if ($params['table'] === 'stars') {
                $str_query = "DELETE FROM stars WHERE id = ?";
            } else {
                return false;
            }
            $query = $this->db->prepare($str_query);
            $query->execute([$params['id']]);
            return $query->rowCount();
        } catch (Exception) {
            return false;
        }
    }

    protected function executeGetAllQuery($sort, $order, $filter, $filterValue, $contains, $str_query)
    {

        if ($filter != null) {
            $str_query .= "\nWHERE ".$filter." LIKE ?";
        }
    
        $str_query .= "\nORDER BY $sort $order";    

        $query = $this->db->prepare($str_query);

        //Si el filtro existe, entonces chequea si "contains" es true o false, en cuyo caso pasa al execute un parámetro u otro (con o sin % en los extremos). Si no hay filtro, no pasa ningún parámetro (puesto que la query no tiene ningún signo de interrogación para ser reemplazado por un parámetro). 

        if ($filter != null) {
            if ($contains) {
                $query->execute(["%" . $filterValue . "%"]);
            } else {
                $query->execute([$filterValue]);
            }
        } else {
            $query->execute();
        }

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
