<?php
require_once "ParentView.php";

class StarView extends ParentView
{

    public function renderTable($data)
    {
        $this->smarty->assign('stars', $data);
        $this->smarty->display('./templates/tables.tpl');
    }
}
