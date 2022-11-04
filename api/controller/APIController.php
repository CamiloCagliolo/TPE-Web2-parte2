<?php
require_once "api/view/APIView.php";

class APIController{
    protected $model;
    protected $view;
    protected $data;

    public function __construct(){
        $this->view = new APIView();
        $this->data = json_decode(file_get_contents("php://input"));
    }

    public function getAll(){

        $filterValue = null;
        $filter = $this->readFilter();
        $contains = false;
        
        if($filter != null){
            $filterValue = $_GET[$filter]; 
        }

        if(isset($_GET["contains"]) && (strtolower($_GET["contains"]) == "true" || strtolower($_GET["contains"]) == "false")){
            $contains = $_GET["contains"] == "true";
        }
        else if(isset($_GET["contains"])){
            $this->view->showMessage('Bad request. "Contains" parameter has to be true or false.', 400);
        }
        
        if(isset($_GET['sort']) && isset($_GET['order'])){
            $data = $this->model->getAllData($_GET['sort'], $_GET['order'], $filter, $filterValue, $contains);
        }
        else if(isset($_GET['sort'])){
            $data = $this->model->getAllData($_GET['sort'], 'ASC', $filter, $filterValue, $contains);
        }
        else{
            $data = $this->model->getAllData('name', 'ASC', $filter, $filterValue, $contains);
        }

        if($data == 400){
            $this->view->showMessage('Bad request. Check your parameters and try again.', 400);
            return;
        }

        if(isset($_GET['page']) && isset($_GET['limit'])){
            $page = intval($_GET['page'])-1;
            $limit = intval($_GET['limit']);
            
            $data = array_slice($data, $page*$limit, $limit);
        }
        else if(isset($_GET['page']) && !isset($_GET['limit'])){
            $this->view->showMessage('Specify a limit value for your pagination.', 400);
            return;
        }
        
        if($data != null){
            $this->view->showData($data);
        }
        else{
            $this->view->showMessage('Nothing found for this request criteria.', 404);
        }
        
    }

    public function getOne(){
        $params = explode('/', $_GET['resource']);
        $id = array_pop($params);
        $data = $this->model->getDataById($id);
        if($data != null){
            $this->view->showData($data);
        }
        else{
            $this->view->showMessage('Resource not found.', 404);
        }
        
    }

    public function deleteEntity(){
        $params = explode('/', $_GET['resource']);
        $id = array_pop($params);
        $success = $this->model->delete($id);
        if($success){
            $this->view->showMessage('Deletion successful.');
        }
        else{
            $this->view->showMessage("Unable to delete the requested item. If you're trying to delete a star, make sure it has no exoplanets associated.", 400);
        }
    }

    protected function add($entity){
        $success = $this->model->insert($entity);
        if($success){
            $this->view->showMessage('Addition successful.', 201);
        }
        else{
            $this->view->showMessage("Addition failed. If you're trying to add an exoplanet, make sure that the method and the star that you're trying to assign exist beforehand, and try again.", 400);
        }
    }

    public function replace(){
        $params = explode('/',$_GET['resource']);
        $id = array_pop($params);
        $this->data->id = $id;
        $success = $this->model->update($this->data);
        if($success){
            $this->view->showMessage('Edition successful.');;
        }
        else{
            $this->view->showMessage("Edition failed. If you're trying to add an exoplanet, make sure that the method and the star that you're trying to assign exist beforehand, and try again.", 400);
        }
    }

    public function returnError(){
        $this->view->showMessage('Resource not found. Check your syntax.', 404);
    }

    protected function readFilter(){
        $possibleFilters = ["name", "mass", "radius", "method", "star", "distance", "type"];
        foreach($possibleFilters as $filter){
            if(isset($_GET[$filter])){
                return $filter;
            }
        }
        return null;
    }
}