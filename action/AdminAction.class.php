<?php
/**
 * 管理員控制器(後台首頁)
 **/
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\SweetAlert;

class AdminAction extends Action
{
    private $_cate = null;

    public function __construct()
    {
        parent::__construct();
        $this->_cate = new EquipmentCateModel();
    }

    //載入資訊
    public function main()
    {
        if (isset($_GET['cate_id'])) {
            $_OneCate = $this->_cate->findOne();

            if (empty($_OneCate['cate_id'])) {
                redirect_header($_SERVER['PHP_SELF'], 3, "無此分類編號");
            }
            $this->_tpl->assign("OneCate", $_OneCate);
            $this->_tpl->assign('now_op', "cate_show_one");
        } else {
            //分頁
            parent::page(20, 10, $this->_cate);
            $_AllCate = $this->_cate->findAll();
            // die(var_dump($_AllCate));
            $this->_tpl->assign('AllCate', $_AllCate);
            $this->_tpl->assign('now_op', 'cate_list');
        }

        $sweet_alert = new SweetAlert();
        $sweet_alert->render('cate_destroy_func',
            "{$_SERVER['PHP_SELF']}?op=delete&cate_id=", "cate_id");
        $this->_tpl->assign('action', $_SERVER['PHP_SELF']);

    }

    // 刪除
    public function delete()
    {
        if (isset($_GET['cate_id'])) {
            $_row = $this->_cate->cate_delete();
        }
        header("location: {$_SERVER['PHP_SELF']}");
    }

    // 分類新增、編輯
    public function cate_form()
    {
        if (isset($_POST['send'])) {
            //XOOPS表單安全檢查
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $error = implode("<br />", $GLOBALS['xoopsSecurity']->getErrors());
                redirect_header($_SERVER['PHP_SELF'], 3, $error);
            }
            if (isset($_POST['next_op'])) {
                if ($_POST['next_op'] == "update") {
                    $_cate_id = $this->_cate->cate_update();
                    if (!empty($_cate_id)) {
                        $_message = "修改成功!";
                    } else {
                        $_message = "修改失敗!";
                    }
                }
                if ($_POST['next_op'] == "add") {
                    $_cate_id = $this->_cate->cate_add();
                    if (!empty($_cate_id)) {
                        $_message = "新增成功!";
                    } else {
                        $_message = "新增失敗";
                    }

                }
            }

            redirect_header($_SERVER['PHP_SELF'], 3, $_message);
            exit();
        }

        if (isset($_GET['cate_id'])) {
            $_OneCate = $this->_cate->findOne();
            $this->_tpl->assign('next_op', "update");
        } else {
            $this->_tpl->assign('next_op', "add");
        }
        $this->_tpl->assign("OneCate", $_OneCate);
        //套用formValidator驗證機制
        $formValidator      = new FormValidator("#myForm", true);
        $formValidator_code = $formValidator->render();
        //加入Token安全機制
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        $token      = new \XoopsFormHiddenToken();
        $token_form = $token->render();
        $this->_tpl->assign("token_form", $token_form);
        $this->_tpl->assign('now_op', "cate_form");
        $this->_tpl->assign('action', $_SERVER['PHP_SELF']);

    }
}
