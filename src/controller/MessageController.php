<?php
require_once 'src/view/MessageView.php';

class MessageController{
    private $view;

    public function __construct($error = null){
        $this->view = new MessageView($error);
    }

    public function errorPage(){
        $this->view->showError();
    }

    public function HTTPMessage($code, $message = null){
        $this->view->returnHTTPMessage($code, $message);
    }
}