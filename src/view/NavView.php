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

    public function showAdd(){
        $this->smarty->assign('title', "Add items");
        $this->smarty->display('./templates/addItems.tpl');
    }

    public function renderMethodSelect($data, $isShort){
        $this->smarty->assign('methods', $data);
        $this->smarty->assign('short', $isShort);
        $this->smarty->display('./templates/selectMethods.tpl');
    }

    public function renderStarSelect($data){
        $this->smarty->assign('stars', $data);
        $this->smarty->display('./templates/selectStars.tpl');
    }
}