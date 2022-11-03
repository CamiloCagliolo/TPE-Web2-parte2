<?php
require_once "api/controller/APIController.php";
require_once "src/model/data-manipulation/ExoplanetModel.php";

class APIExoplanetController extends APIController{

    public function __construct(){
        parent::__construct();
        $this->model = new ExoplanetModel();
    }
}