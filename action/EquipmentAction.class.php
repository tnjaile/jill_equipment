<?php
/**
 * 設備控制器(後台首頁)
 **/
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\SweetAlert;

class EquipmentAction extends Action
{

    private $_cate = null;
    public function __construct()
    {
        parent::__construct();
        $this->_cate = new EquipmentCateModel();

        list($this->_F['cate_id'],
            $this->_F['sn']) = $this->getArry(array(
            isset($_REQUEST['cate_id']) ? Tool::setFormString($_REQUEST['cate_id'], "int") : null,
            isset($_REQUEST['sn']) ? Tool::setFormString($_REQUEST['sn'], "int") : null));
    }

    //載入資訊
    public function main()
    {
        if (isset($_GET['sn'])) {
            $_OneEquipment = $this->_model->findOne();
            if (empty($_OneEquipment)) {
                redirect_header($_SERVER['PHP_SELF'], 3, "無此設備編號");
            }

        }

        $_cate_id = (isset($_GET['sn'])) ? $_OneEquipment['cate_id'] : $this->_F['cate_id'];

        $_OneCate = $this->_cate->findOne(array("cate_id='{$_cate_id}'"));
        if (empty($_OneCate)) {
            redirect_header("main.php", 3, "無此分類編號");
        }

        if (isset($_GET['sn'])) {
            $this->_tpl->assign("OneEquipment", $_OneEquipment);
            $this->_tpl->assign('now_op', "equipment_show_one");

        } else {
            //分頁
            parent::page(20, 10, $this->_model);
            $_AllEquipment = $this->_model->findAll();
            $this->_tpl->assign('AllEquipment', $_AllEquipment);
            $this->_tpl->assign('now_op', 'equipment_list');
        }
        $sweet_alert = new SweetAlert();
        $sweet_alert->render('equipment_destroy_func',
            "{$_SERVER['PHP_SELF']}?op=delete&cate_id={$_OneCate['cate_id']}&sn=", "sn");

        $this->_tpl->assign('action', $_SERVER['PHP_SELF']);
        $this->_tpl->assign("OneCate", $_OneCate);
    }

    // 刪除
    public function delete()
    {
        if (isset($_GET['sn'])) {
            $_row = $this->_model->equipment_delete();
        }
        header("location: {$_SERVER['PHP_SELF']}?cate_id={$this->_F['cate_id']}");
        exit();
    }

    // 新增、編輯
    public function equipment_form()
    {
        if (isset($_POST['send'])) {
            //XOOPS表單安全檢查
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $error = implode("<br />", $GLOBALS['xoopsSecurity']->getErrors());
                redirect_header($_SERVER['PHP_SELF'], 3, $error);
            }
            if (isset($_POST['next_op'])) {
                if ($_POST['next_op'] == "update") {
                    $_sn = $this->_model->equipment_update();
                    if (!empty($_sn)) {
                        $_message = "修改成功!";
                    } else {
                        $_message = "修改失敗!";
                    }
                }
                if ($_POST['next_op'] == "add") {
                    $_sn = $this->_model->equipment_add();
                    if (!empty($_sn)) {
                        $_message = "新增成功!";
                    } else {
                        $_message = "新增失敗";
                    }

                }
            }

            redirect_header($_SERVER['PHP_SELF'] . "?cate_id={$this->_F['cate_id']}", 3, $_message);
        }

        // 過濾掉訪客
        $_AllGroup = Group::get_all_groups(array(3));
        // die(var_dump($_AllGroup));
        if (isset($_GET['sn'])) {
            $_OneEquipment = $this->_model->findOne();
            $_cate_id      = $_OneEquipment['cate_id'];
            $this->_tpl->assign('next_op', "update");
        } else {
            if (!isset($_GET['cate_id']) || empty($this->_F['cate_id'])) {
                redirect_header("main.php", 3, "請輸入設備編號");
            }
            $_OneEquipment['booking_group'] = array(2);
            $this->_tpl->assign('next_op', "add");
            $_cate_id = $this->_F['cate_id'];
        }

        $_OneCate = $this->_cate->findOne(array("cate_id='{$_cate_id}'"));
        if (empty($_OneCate)) {
            redirect_header("main.php", 3, "無此分類編號");
        }

        $this->_tpl->assign("OneCate", $_OneCate);
        $this->_tpl->assign("OneEquipment", $_OneEquipment);
        $this->_tpl->assign("AllGroup", $_AllGroup);

        // 引入ckeditor
        $_directions = (empty($_OneEquipment['directions'])) ? "" : $_OneEquipment['directions'];
        $ck          = new CkEditor("jill_equipment", "directions", $_directions);
        $ck->setHeight(200);
        $this->_tpl->assign('directions_editor', $ck->render());

        //套用formValidator驗證機制
        $formValidator      = new FormValidator("#myForm", true);
        $formValidator_code = $formValidator->render();
        //加入Token安全機制
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        $token      = new \XoopsFormHiddenToken();
        $token_form = $token->render();
        $this->_tpl->assign("token_form", $token_form);
        $this->_tpl->assign('now_op', "equipment_form");
        $this->_tpl->assign('action', $_SERVER['PHP_SELF']);
    }
}
