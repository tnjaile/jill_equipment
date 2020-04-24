<?php
class EquipmentTimeModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        // 要顯示的欄位及欄位類型
        $this->_fields = array('tsn' => 'int', 'sn' => 'int', 'title' => 'string', 'tsort' => 'int', 'open_week' => 'string');
        // 要查詢的表
        $this->_tables = array(DB_PREFIX . "jill_equipment_time");
        // 欄位檢查
        $this->_check = new Check();
        // 過濾參數
        list($this->_R['source'],
            $this->_R['tsn'],
            $this->_R['sn']
        ) = $this->getRequest()->getParam(array(
            isset($_GET['source']) ? Tool::setFormString($_GET['source'], "int") : null,
            isset($_REQUEST['tsn']) ? Tool::setFormString($_REQUEST['tsn'], "int") : null, isset($_REQUEST['sn']) ? Tool::setFormString($_REQUEST['sn'], "int") : null));
    }

    public function time_delete($_whereData)
    {
        $_where = (empty($_whereData)) ? array("tsn='{$this->_R['tsn']}'") : $_whereData;

        return parent::delete($_where);
    }

    public function time_add()
    {
        $_where = array("sn='{$this->_R['sn']}' ");
        // 過濾POST
        $_addData          = $this->getRequest()->filter($this->_fields);
        $_addData['tsort'] = $this->getSort('tsort', $_where) + 1;
        // 去除自動遞增
        unset($_addData['tsn']);
        // die(var_dump($_addData));
        return parent::add($_addData);
    }

    public function findOne($_whereData = array(), $_selectData = array())
    {
        $_where = (empty($_whereData)) ? array("tsn='{$this->_R['tsn']}'") : $_whereData;
        // 先驗證是否有此編號的資料
        if (!$this->_check->oneCheck($this, $_where)) {
            return;
        }

        $_selectData = empty($_selectData) ? $this->_fields : $_selectData;

        // 秀出此編號的詳細資訊
        $_One = parent::select($_selectData, array('where' => $_where, 'limit' => '1'));
        if (!empty($_One)) {
            return $_One[0];
        }
    }

    public function findAll($_whereData = array(), $_selectData = array())
    {
        $_where = (empty($_whereData)) ? array() : $_whereData;

        $_selectData = empty($_selectData) ? $this->_fields : $_selectData;
        $_All        = parent::select($_selectData, array('where' => $_where, 'limit' => $this->_limit, 'order' => 'tsort'));
        if (!empty($_All)) {
            return $_All;
        }
    }

    // 顯示設備資訊
    public function findEquipment()
    {
        $this->_fields = array('count(a.tsn) as counter' => 'int', 'a.sn' => 'int', 'b.title' => 'string');
        // 要查詢的表
        $this->_tables = array(DB_PREFIX . 'jill_equipment_time as a join ' . DB_PREFIX . 'jill_equipment as b on a.sn=b.sn');

        $_All = parent::select($this->_fields, array('join' => 'join', 'group' => 'a.sn'));

        if (!empty($_All)) {
            $_EquipmentInfo = [];
            foreach ($_All as $key => $value) {
                $_EquipmentInfo[$value['sn']] = sprintf(_MA_JILLEQUIPMENT_IMPORT_TIME, $value['title'], $value['counter']);
            }
            return $_EquipmentInfo;
        }
    }

    // //複製時間區段
    public function time_copy()
    {
        $_AllSource = $this->findAll(array("sn='{$this->_R['source']}'"));
        if (!empty($_AllSource)) {
            $_addData = [];
            foreach ($_AllSource as $key => $value) {
                $_addData['sn']        = $this->_R['sn'];
                $_addData['title']     = $value['title'];
                $_addData['tsort']     = $value['tsort'];
                $_addData['open_week'] = $value['open_week'];
                parent::add($_addData);
            }
            return true;
        }
    }

}
