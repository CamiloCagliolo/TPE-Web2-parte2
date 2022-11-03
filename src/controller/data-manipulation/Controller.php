<?php

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
                (new MessageController())->HTTPMessage(200, 'Deletion successful.');
            }
            else{
                (new MessageController())->HTTPMessage(400, "Deletion failed. If you're trying to delete a star, make sure it doesn't have any associated exoplanet, and try again.");
            }
        }
        else{
            (new MessageController())->HTTPMessage(403, "You don't have enough permissions.");
        }
    }
    
    protected function add($entity){
        $success = $this->model->insert($entity);
        if($success){
            (new MessageController())->HTTPMessage(200, 'Addition successful.');
        }
        else{
            (new MessageController())->HTTPMessage(400, 'Addition failed. Try again.');
        }
    }

    public function replace(){
        if($this->session){
            $success = $this->model->update($this->data);
            if($success){
                (new MessageController())->HTTPMessage(200, 'Exoplanet edition successful.');
            }
            else{
                (new MessageController())->HTTPMessage(400, 'Edition failed. Try again.');
            }
        }
        else{
            (new MessageController())->HTTPMessage(403, "You don't have enough permissions.");
        }
    }
}