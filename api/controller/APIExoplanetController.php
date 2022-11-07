<?php
require_once "api/controller/APIController.php";
require_once "src/model/data-manipulation/ExoplanetModel.php";

class APIExoplanetController extends APIController
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new ExoplanetModel();
    }

    public function addExoplanet()
    {
        $data = $this->data;
        $exoplanet = [$data->name, $data->mass, $data->radius, $data->method, $data->star];
        parent::add($exoplanet);
    }
}
