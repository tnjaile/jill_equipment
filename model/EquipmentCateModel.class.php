<?php
class EquipmentCateModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        // 要顯示的欄位及欄位類型
        $this->_fields = array('cate_id' => 'int', 'cate_name' => 'string', 'is_enable' => 'int', 'cate_sort' => 'int');
        // 要查詢的表
        $this->_tables = array(DB_PREFIX . "jill_equipment_cate");
        // 欄位檢查
        $this->_check = new CateCheck();
        // 過濾參數
        list($this->_R['cate_id']) = $this->getRequest()->getParam([
            isset($_REQUEST['cate_id']) ? Tool::setFormString($_REQUEST['cate_id'], "int") : null]);
    }

    public function cate_delete()
    {
        $_where = array("cate_id='{$this->_R['cate_id']}'");
        return parent::delete($_where);
    }

    public function cate_add()
    {
        if (!$this->_check->addCheck($this)) {
            return;
        }
        $_addData = $this->getRequest()->filter($this->_fields);
        // 去除自動遞增
        unset($_addData['cate_id']);
        $_addData['cate_sort'] = $this->getSort('cate_sort') + 1;
        return parent::add($_addData);
    }

    public function cate_update($_selectData = array(), $_ischeck = 1)
    {
        $_where = array("cate_id='{$this->_R['cate_id']}'");
        if (!$this->_check->oneCheck($this, $_where)) {
            return;
        }
        if (!empty($_ischeck)) {
            if (!$this->_check->addCheck($this)) {
                return;
            }
        }
        $_selectData = empty($_selectData) ? $this->_fields : $_selectData;
        $_updateData = $this->getRequest()->filter($_selectData);
        parent::update($_where, $_updateData);
        return $this->_R['cate_id'];
    }
    public function findOne($_whereData = array())
    {
        $_where = (empty($_whereData)) ? array("cate_id='{$this->_R['cate_id']}'") : $_whereData;
        //先驗證是否有此編號的資料
        if (!$this->_check->oneCheck($this, $_where)) {
            return;
        }

        // 秀出此編號的詳細資訊
        $_OneCate = parent::select($this->_fields, array('where' => $_where, 'limit' => '1'));
        return $_OneCate[0];
    }

    public function findAll($_whereData = array(), $_selectData = array())
    {
        $_where = (empty($_whereData)) ? array() : $_whereData;

        $_selectData = empty($_selectData) ? $this->_fields : $_selectData;
        $_All        = parent::select($_selectData, array('where' => $_where, 'limit' => $this->_limit, 'order' => 'cate_sort desc'));
        return $_All;
    }
    public function allNum()
    {
        return parent::total();
    }

}
