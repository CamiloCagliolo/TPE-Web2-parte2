<?php
require_once "src/model/MethodModel.php";
require_once "src/view/NavView.php";
require_once "src/helper/MessageHelper.php";

class NavController{
    private $model;
    private $view;
    private $session;

    public function __construct(){
        $this->model = new MethodModel();
        $this->view = new NavView();
        $this->session = isset($_SESSION['username']);
    }

    public function sectionHome(){
        $methods = $this->model->getMethods();
        $this->view->showHome($methods);
    }

    public function sectionLogin(){
        if(!$this->session){
            $this->view->showLogin();
        }
        else{
            $error = "logged";
            (new MessageHelper($error))->showError();
        }
    }

    public function sectionRegister(){
        if(!$this->session){
            $this->view->showRegister();
        }
        else{
            $error = 'cantregister';
            (new MessageHelper($error))->showError();
        }
    }

    public function sectionTerms(){
        $this->view->showTerms();
    }

    public function sectionTables(){
        $this->view->showTables();
    }

    public function sectionAdd(){
        if($this->session){
            $this->view->showAdd();
        }
        else{
            (new MessageHelper("permission"))->showError();
        }
        
    }

    public function buildMethodSelect(){
        $actions = explode('/', $_GET['action']);
        $isShort = (array_pop($actions) == 'short');
        $data = $this->model->getMethods();
        $this->view->renderMethodSelect($data, $isShort);
    }

    public function buildStarSelect(){
        $data = (new StarModel())->getAllData('name', 'ASC', null, null, "false");
        $this->view->renderStarSelect($data);
    }

    
}