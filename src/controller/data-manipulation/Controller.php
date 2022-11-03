<?php
require_once "src/helper/MessageHelper.php";
class Controller{
    protected $model;
    protected $view;
    protected $session;
    protected $data;

    protected function __construct(){
        $this->session = isset($_SESSION['username']);
        $this->data = json_decode(file_get_contents("php://input"));
    }

    public function buildTable(){
        $data = $this->model->getAllData();
        $this->view->renderTable($data);
    }

    public function delete(){
        if($this->session){
            $params = explode('/',$_GET['action']);
            $id = array_pop($params);
            $success = $this->model->delete($id);
            if($success){
                (new MessageHelper())->returnHTTPMessage(200, 'Deletion successful.');
            }
            else{
                (new MessageHelper())->returnHTTPMessage(400, "Deletion failed. If you're trying to delete a star, make sure it doesn't have any associated exoplanet, and try again.");
            }
        }
        else{
            (new MessageHelper())->returnHTTPMessage(403, "You don't have enough permissions.");
        }
    }
    
    protected function add($entity){
        $success = $this->model->insert($entity);
        if($success){
            (new MessageHelper())->returnHTTPMessage(201, 'Addition successful.');
        }
        else{
            (new MessageHelper())->returnHTTPMessage(400, 'Addition failed. Try again.');
        }
    }

    public function replace(){
        if($this->session){
            $params = explode('/',$_GET['action']);
            $id = array_pop($params);
            $this->data->id = $id;
            $success = $this->model->update($this->data);
            if($success){
                (new MessageHelper())->returnHTTPMessage(200, 'Edition successful.');
            }
            else{
                (new MessageHelper())->returnHTTPMessage(400, 'Edition failed. Try again.');
            }
        }
        else{
            (new MessageHelper())->returnHTTPMessage(403, "You don't have enough permissions.");
        }
    }
}