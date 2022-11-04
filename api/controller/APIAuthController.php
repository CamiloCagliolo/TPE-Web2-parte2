<?php

class AuthController{
    private $helper;
    private $view;

    public function __construct(){
        $helper = new APIAuthHelper();
        $view = new APIView();
    }

    public function getToken(){
        
    }
}