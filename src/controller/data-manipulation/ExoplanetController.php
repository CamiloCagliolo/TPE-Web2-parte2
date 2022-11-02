<?php
require_once "Controller.php";
require_once "./././src/controller/MessageController.php";
require_once "./././src/model/data-manipulation/ExoplanetModel.php";
require_once "./././src/view/ExoplanetView.php";

class ExoplanetController extends Controller{
    private $data;
    

    public function __construct(){
        $this->model = new ExoplanetModel();
        $this->view = new ExoplanetView();
        $this->session = isset($_SESSION['username']);
        $this->data = json_decode(file_get_contents("php://input"));
    }

    public function replaceExoplanet(){
        if($this->session){
            $success = $this->model->updateExoplanet($this->data);
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

    public function deleteExoplanet(){
        if($this->session){
            $params = explode('/',$_GET['action']);
            $id = array_pop($params);
            $success = $this->model->deleteExoplanet($id);
            if($success){
                (new MessageController())->HTTPMessage(200, 'Exoplanet deletion successful.');
            }
            else{
                (new MessageController())->HTTPMessage(400, 'Deletion failed. Try again.');
            }
        }
        else{
            (new MessageController())->HTTPMessage(403, "You don't have enough permissions.");
        }
    }

    public function addExoplanet(){
        if($this->session){
            $exo = $this->data;
            $exoplanet = [$exo->name, $exo->mass, $exo->radius,$exo->method, $exo->star];
            $success = $this->model->insertExoplanet($exoplanet);
            if($success){
                (new MessageController())->HTTPMessage(200, 'Exoplanet addition successful.');
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