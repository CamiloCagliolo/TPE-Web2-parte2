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
            $star = $this->data;
            $star = [$star->name, $star->mass, $star->radius,$star->distance, $star->type];
            parent::add($star);
        }
        else{
            (new MessageController())->HTTPMessage(403, "You don't have enough permissions.");
        }
    }
}