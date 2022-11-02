<?php
require_once "ParentView.php";

class NavView extends ParentView{

    public function showHome($methods){
        $this->smarty->assign('title', 'Exoplanets: home');
        $this->smarty->assign('methods', $methods);
        $this->smarty->display("./templates/home.tpl");
    }

    public function showLogin(){
        $this->smarty->assign('title', 'Log in');
        $this->smarty->display('./templates/login.tpl');
    }

    public function showRegister(){
        $this->smarty->assign('title', 'Register');
        $this->smarty->display('./templates/register.tpl');
    }

    public function showTerms(){
        $this->smarty->assign('title', "Whoops...");
        $this->smarty->display('./templates/terms.tpl');
    }

    public function showTables(){
        $this->smarty->assign('title', 'Exoplanets: tables');
        $this->smarty->display('./templates/tables_page.tpl');
    }

    public function renderSelect($data, $short){
        $this->smarty->assign('methods', $data);
        $this->smarty->assign('short', $short);
        $this->smarty->display('./templates/selectMethods.tpl');
    }
}