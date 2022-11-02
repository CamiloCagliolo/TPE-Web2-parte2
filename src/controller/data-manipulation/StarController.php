<?php

require_once "Controller.php";
require_once "src/model/data-manipulation/StarModel.php";
require_once "src/view/StarView.php";

class StarController extends Controller{
    private $data;

    public function __construct(){
        $this->model = new StarModel();
        $this->view = new StarView();
        $this->session = isset($_SESSION['username']);
        $this->data = json_decode(file_get_contents("php://input"));
    }

    public function replaceStar(){
        if($this->session){
            $success = $this->model->updateStar($this->data);
            if($success){
                (new MessageController())->HTTPMessage(200, 'Star edition successful.');
            }
            else{
                (new MessageController())->HTTPMessage(400, 'Edition failed. Try again.');
            }
        }
        else{
            (new MessageController())->HTTPMessage(403, "You don't have enough permissions.");
        }
    }

    public function deleteStar(){
        if($this->session){
            $params = explode('/',$_GET['action']);
            $id = array_pop($params);
            $success = $this->model->deleteStar($id);
            if($success){
                (new MessageController())->HTTPMessage(200, 'Star deletion successful.');
            }
            else{
                (new MessageController())->HTTPMessage(400, 'Deletion failed. Try again.');
            }
        }
        else{
            (new MessageController())->HTTPMessage(403, "You don't have enough permissions.");
        }
    }

    public function addStar(){
        if($this->session){
            $star = $this->data;
            $star = [$star->name, $star->mass, $star->radius,$star->distance, $star->type];
            $success = $this->model->insertStar($star);
            if($success){
                (new MessageController())->HTTPMessage(200, 'Star addition successful.');
            }
            else{
                (new MessageController())->HTTPMessage(400, 'Addition failed. Try again.');
            }
        }
        else{
            (new MessageController())->HTTPMessage(403, "You don't have enough permissions.");
        }
    }
}