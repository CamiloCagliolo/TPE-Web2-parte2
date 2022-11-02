<?php
require_once "ParentView.php";

class ExoplanetView extends ParentView{

    public function renderTable($data){
        $this->smarty->assign('exoplanets', $data);
        $this->smarty->display('./templates/tables.tpl');
    }
}