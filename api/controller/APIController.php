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
        $data = $this->model->getAllData();
        $this->view->showData($data);
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
            $this->view->showMessage('Unable to delete the requested item.', 400);
        }
    }

    protected function add($entity){
        $success = $this->model->insert($entity);
        if($success){
            $this->view->showMessage('Addition successful.');
        }
        else{
            $this->view->showMessage("Addition failed. If you're trying to add an exoplanet, make sure that the method and the star that you're trying to assign exist beforehand, and try again.", 400);
        }
    }

    public function returnError(){
        $this->view->showMessage('Resource not found. Check your syntax.', 404);
    }
}