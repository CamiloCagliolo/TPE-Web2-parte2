<?php
require_once "api/view/APIView.php";

class APIController{
    protected $model;
    protected $view;
    protected $data;

    public function __construct(){
        $this->view = new APIView();
        $this->data = json_decode("http//input");
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

    public function returnError(){
        $this->view->showMessage('Resource not found. Check your syntax.', 404);
    }
}