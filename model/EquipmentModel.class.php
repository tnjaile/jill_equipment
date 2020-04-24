<?php
class EquipmentModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        // 要顯示的欄位及欄位類型
        $this->_fields = array('sn' => 'int', 'cate_id' => 'int', 'title' => 'string', 'directions' => 'ckeditor', 'total' => 'int', 'auditor' => 'string', 'booking_group' => 'json');
        // 要查詢的表
        $this->_tables = array(DB_PREFIX . "jill_equipment");
        // 欄位檢查
        $this->_check = new EquipmentCheck();
        // 過濾參數
        list($this->_R['sn']) = $this->getRequest()->getParam(array(
            isset($_REQUEST['sn']) ? Tool::setFormString($_REQUEST['sn'], "int") : null));
    }

    public function equipment_delete($_whereData)
    {
        $_where = (empty($_whereData)) ? array("sn='{$this->_R['sn']}'") : $_whereData;

        return parent::delete($_where);
    }
    public function equipment_add()
    {
        global $xoopsUser;
        if (!$this->_check->addCheck($this)) {
            return;
        }

        // 過濾POST
        $_addData = $this->getRequest()->filter($this->_fields);
        // 去除自動遞增
        unset($_addData['sn']);
        return parent::add($_addData);
    }

    public function equipment_update($_selectData = array())
    {
        $_where = array("sn='{$this->_R['sn']}'");

        if (!$this->_check->oneCheck($this, $_where)) {
            return;
        }

        if (!$this->_check->addCheck($this)) {
            return;
        }

        $_selectData = empty($_selectData) ? $this->_fields : $_selectData;
        $_updateData = $this->getRequest()->filter($_selectData);

        parent::update($_where, $_updateData);
        return $this->_R['sn'];
    }

    public function findOne($_whereData = array(), $_selectData = array())
    {
        $_where = (empty($_whereData)) ? array("sn='{$this->_R['sn']}'") : $_whereData;
        // 先驗證是否有此編號的資料
        if (!$this->_check->oneCheck($this, $_where)) {
            return;
        }

        $_selectData = empty($_selectData) ? $this->_fields : $_selectData;

        // 秀出此編號的詳細資訊
        $_One = parent::select($_selectData, array('where' => $_where, 'limit' => '1'));
        if (!empty($_One)) {
            // 預約群組
            if (!empty($_One[0]['booking_group'])) {
                $_One[0]['booking_name'] = "";
                foreach ($_One[0]['booking_group'] as $_group_id) {
                    $_One[0]['booking_name'] .= Group::get_groupname($_group_id) . " | ";
                }
            } else {
                $_One[0]['booking_name'] = "尚未指定";
            }
            return $_One[0];
        }
    }

    public function findAll($_whereData = array(), $_selectData = array())
    {
        $_where = (empty($_whereData)) ? array() : $_whereData;

        $_selectData = empty($_selectData) ? $this->_fields : $_selectData;
        $_All        = parent::select($_selectData, array('where' => $_where, 'limit' => $this->_limit, 'order' => 'sn'));
        if (!empty($_All)) {
            // 預約群組
            foreach ($_All as $key => $value) {
                if (!empty($value['booking_group'])) {
                    $_All[$key]['booking_name'] = "";
                    foreach ($value['booking_group'] as $_group_id) {
                        $_All[$key]['booking_name'] .= Group::get_groupname($_group_id) . " | ";
                    }
                } else {
                    $_All[$key]['booking_name'] = "尚未指定";
                }
            }
            return $_All;
        }
    }

    public function allNum()
    {
        return parent::total();
    }

}
