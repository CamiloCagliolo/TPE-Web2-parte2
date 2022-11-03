<?php
require_once "api/controller/APIController.php";
require_once "src/model/data-manipulation/StarModel.php";


class APIStarController extends APIController{

    public function __construct(){
        parent::__construct();
        $this->model = new StarModel();
    }

    public function addStar(){
        $data = $this->data;
        $star = [$data->name, $data->mass, $data->radius,$data->distance, $data->type];
        parent::add($star);
    }
}