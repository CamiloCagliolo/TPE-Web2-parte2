<?php
require_once "Controller.php";
require_once "src/model/data-manipulation/StarModel.php";
require_once "src/view/StarView.php";

class StarController extends Controller{

    public function __construct(){
        parent::__construct();
        $this->model = new StarModel();
        $this->view = new StarView();
    }

    public function addStar(){
        if($this->session){
            $data = $this->data;
            $star = [$data->name, $data->mass, $data->radius,$data->distance, $data->type];
            parent::add($star);
        }
        else{
            (new MessageHelper())->returnHTTPMessage(403, "You don't have enough permissions.");
        }
    }
}