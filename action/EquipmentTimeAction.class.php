<?php
/**
 * 時段控制器
 **/
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\Jeditable;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\Utility;

class EquipmentTimeAction extends Action
{
    private $_equipment      = null;
    private $_equipment_date = null;
    private $_OneEquipment   = null;
    public function __construct()
    {
        parent::__construct();
        $this->_equipment      = new EquipmentModel();
        $this->_equipment_date = new EquipmentDateModel();

        list($this->_F['type'],
            $this->_F['sn']
        ) = $this->getArry(array(
            isset($_REQUEST['type']) ? Tool::setFormString($_REQUEST['type'], "string") : null,
            isset($_REQUEST['sn']) ? Tool::setFormString($_REQUEST['sn'], "int") : null,
        ));

        $_OneEquipment = $this->_equipment->findOne();
        if (empty($_OneEquipment)) {
            redirect_header("main.php", 3, "無此設備編號");
        }
        $this->_tpl->assign("OneEquipment", $_OneEquipment);
    }

    //載入資訊
    public function main()
    {
        $_AllTime = $this->_model->findAll(array("sn='{$this->_F['sn']}'"));

        foreach ($_AllTime as $key => $value) {
            if (!empty($value['open_week'])) {
                $_AllTime[$key]['open_week_arr'] = explode(',', $value['open_week']);

            } else {
                $_AllTime[$key]['open_week_arr'] = [];
            }

            $_booking_times = $this->_equipment_date->allNum(array("tsn='{$value['tsn']}'"));

            $_AllTime[$key]['booking_times'] = empty($_booking_times) ? "" : sprintf(_MA_JILLEQUIPMENT_BOOKING_TIME, $_booking_times);
        }
        // die(var_dump($_AllTime));
        $this->_tpl->assign('AllTime', $_AllTime);
        $this->_tpl->assign('now_op', 'time_list');

        // 排序
        $this->_tpl->assign('jquery', Utility::get_jquery(true));

        $sweet_alert = new SweetAlert();
        $sweet_alert->render('time_destroy_func',
            "{$_SERVER['PHP_SELF']}?op=delete&sn={$this->_F['sn']}&tsn=", "tsn");
        $this->_tpl->assign('action', $_SERVER['PHP_SELF']);

        //套用formValidator驗證機制
        $formValidator      = new FormValidator("#myForm", true);
        $formValidator_code = $formValidator->render();

        // 點擊編輯
        $jeditable = new Jeditable();
        $jeditable->setTextCol(".jq_title", 'equipmentTime_ajax.php', '50%', '1.2em', "{'op' : 'save_title'}", _TAD_EDIT . _MA_JILLEQUIPMENT_TIME_TITLE);
        $jeditable->render();

        // 抓現有設備及時段
        $_EquipmentInfo = $this->_model->findEquipment();
        $this->_tpl->assign('EquipmentInfo', $_EquipmentInfo);

    }

    //從範本快速匯入時段設定
    public function time_import()
    {
        switch ($this->_F['type']) {
            case '18':
                for ($i = 1; $i <= 8; $i++) {
                    $_POST['sn']        = $this->_F['sn'];
                    $_POST['title']     = sprintf(_MA_JILLEQUIPMENT_N_TIME, $i);
                    $_POST['open_week'] = '1,2,3,4,5';
                    $this->_model->time_add();
                }

                break;
            case 'apm':
                $apm_arr[1] = _MA_JILLEQUIPMENT_AM;
                $apm_arr[2] = _MA_JILLEQUIPMENT_PM;
                for ($i = 1; $i <= 2; $i++) {
                    $_POST['sn']        = $this->_F['sn'];
                    $_POST['title']     = $apm_arr[$i];
                    $_POST['open_week'] = '1,2,3,4,5';
                    $this->_model->time_add();
                }
                break;
            case 'copy':
                $this->_model->time_copy();
                break;
        }
        header("location: {$_SERVER['PHP_SELF']}?sn={$this->_F['sn']}");
        exit();
    }

    // 刪除
    public function delete()
    {
        if (isset($_GET['tsn'])) {
            $this->_model->time_delete();
        }
        header("location: {$_SERVER['PHP_SELF']}?sn={$this->_F['sn']}");
        exit();
    }

    // 新增
    public function time_form()
    {
        if (isset($_POST['send'])) {
            $_POST['open_week'] = implode(',', $_POST['open_week_arr']);

            $_sn = $this->_model->time_add();
            if (!empty($_sn)) {
                $_message = "新增成功!";
            } else {
                $_message = "新增失敗";
            }
            redirect_header($_SERVER['PHP_SELF'] . "?sn={$this->_F['sn']}", 3, $_message);
        }
    }
}
