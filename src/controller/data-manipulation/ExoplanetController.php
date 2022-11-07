<?php
require_once "Controller.php";
require_once "src/model/data-manipulation/ExoplanetModel.php";
require_once "src/view/ExoplanetView.php";

class ExoplanetController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new ExoplanetModel();
        $this->view = new ExoplanetView();
    }


    public function addExoplanet()
    {
        if ($this->session) {
            $data = $this->data;
            $exoplanet = [$data->name, $data->mass, $data->radius, $data->method, $data->star];
            parent::add($exoplanet);
        } else {
            (new MessageHelper())->returnHTTPMessage(403, "You don't have enough permissions.");
        }
    }
}
