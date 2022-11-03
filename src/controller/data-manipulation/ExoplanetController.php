<?php
require_once "Controller.php";
require_once "./././src/controller/MessageController.php";
require_once "./././src/model/data-manipulation/ExoplanetModel.php";
require_once "./././src/view/ExoplanetView.php";

class ExoplanetController extends Controller{

    public function __construct(){
        parent::__construct();
        $this->model = new ExoplanetModel();
        $this->view = new ExoplanetView();
    }


    public function addExoplanet(){
        if($this->session){
            $exo = $this->data;
            $exoplanet = [$exo->name, $exo->mass, $exo->radius,$exo->method, $exo->star];
            parent::add($exoplanet);
        }
        else{
            (new MessageController())->HTTPMessage(403, "You don't have enough permissions.");
        }
    }
}