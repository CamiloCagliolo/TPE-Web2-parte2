<?php
require_once "src/view/ParentView.php";

class MessageHelper extends ParentView{

    public function __construct($error = null){
        parent::__construct();
        $this->smarty->assign("error", $error);
    }

    public function showError(){
        $this->smarty->assign('title', 'Error');
        $this->smarty->display("./templates/error.tpl");
    }

    public function returnHTTPMessage($code = 404, $message = null){
        header("HTTP/1.1 " . $code . " " . $this->_requestStatus($code));

        if ($message != null){
            echo $message;
        }  
    }

    private function _requestStatus($code){
        $status = array(
          200 => "OK",
          201 => "Created",
          400 => "Bad request",
          401 => "Unauthorized",
          403 => "Forbidden",
          404 => "Not found",
          409 => "Conflict",
          500 => "Internal Server Error"
        );
        return (isset($status[$code])) ? $status[$code] : $status[500];
      }
}