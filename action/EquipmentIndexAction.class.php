<?php
/**
 * 前台首頁
 **/
class EquipmentIndexAction extends Action
{
    private $_equipment = null;
    public function __construct()
    {
        parent::__construct();
        $this->_equipment = new EquipmentModel();
    }

    //
    public function main()
    {
        $this->_tpl->assign('main', "前台");
    }

}
