<?php
require_once "././libs/smarty/libs/Smarty.class.php";

class ParentView{
    protected $smarty;

    public function __construct(){
        $this->smarty = new Smarty();
        $this->smarty->assign('BASE_URL', BASE_URL);
        $this->smarty->assign("session", isset($_SESSION['username']));
    }
}