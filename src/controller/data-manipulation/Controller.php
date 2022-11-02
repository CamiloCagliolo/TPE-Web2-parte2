<?php

abstract class Controller{
    protected $model;
    protected $view;
    protected $session;

    public function buildTable(){
        $data = $this->model->getAllData();
        $this->view->renderTable($data);
    }

    
}