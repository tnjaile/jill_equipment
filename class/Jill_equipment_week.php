<?php
namespace XoopsModules\Jill_equipment;

use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Jill_equipment\Jill_equipment_week;
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\FormValidator;

/**
 * Jill Equipment module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Jill Equipment
 * @since      2.5
 * @author     Jill(tnjaile@gmail.com)
 * @version    $Id $
 **/


class Jill_equipment_week
{
    //列出所有 jill_equipment_week 資料
    public static function index()
    {
        global $xoopsDB, $xoopsTpl;

        $myts = \MyTextSanitizer::getInstance();
        
        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_week") . "` ";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        $all_jill_equipment_week = [];
        while($all = $xoopsDB->fetchArray($result))
        {
            //過濾讀出的變數值
            $all['bsn'] = (int) $all['bsn'];
            $all['week'] = (int) $all['week'];
            $all['tsn'] = (int) $all['tsn'];
    
            
            $all_jill_equipment_week[] = $all;
        }

        //刪除確認的JS
        $SweetAlert   = new SweetAlert();
        $SweetAlert->render('jill_equipment_week_destroy_func',
        "{$_SERVER['PHP_SELF']}?op=jill_equipment_week_destroy&bsn_week_tsn=", "bsn_week_tsn");

        
        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
        $xoopsTpl->assign('all_jill_equipment_week', $all_jill_equipment_week);
    }


    //jill_equipment_week編輯表單
    public static function create($bsn_week_tsn = '' )
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;
        chk_is_adm();

        //抓取預設值
        $DBV = !empty($bsn_week_tsn)? self::get($bsn_week_tsn) : [];

        //預設值設定
        
        //設定 bsn 欄位的預設值
        $bsn = !isset($DBV['bsn']) ? $bsn : $DBV['bsn'];
        $xoopsTpl->assign('bsn', $bsn);
        //設定 week 欄位的預設值
        $week = !isset($DBV['week']) ? $week : $DBV['week'];
        $xoopsTpl->assign('week', $week);
        //設定 tsn 欄位的預設值
        $tsn = !isset($DBV['tsn']) ? $tsn : $DBV['tsn'];
        $xoopsTpl->assign('tsn', $tsn);

        $op = empty($bsn_week_tsn) ? "jill_equipment_week_store" : "jill_equipment_week_update";

        //套用formValidator驗證機制
        $formValidator = new FormValidator("#myForm", true);
        $formValidator->render();

        
    
        //加入Token安全機制
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token = new \XoopsFormHiddenToken();
        $token_form = $token->render();
        $xoopsTpl->assign("token_form", $token_form);
        $xoopsTpl->assign('action', $_SERVER["PHP_SELF"]);
        $xoopsTpl->assign('next_op', $op);
    }


    //新增資料到jill_equipment_week中
    public static function store()
    {
        global $xoopsDB, $xoopsUser;
        chk_is_adm();

        
        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();
        
        $bsn = (int) $_POST['bsn'];
        $week = (int) $_POST['week'];
        $tsn = (int) $_POST['tsn'];

        $sql = "insert into `" . $xoopsDB->prefix("jill_equipment_week") . "` (
        `bsn`, 
        `week`, 
        `tsn`
        ) values(
        '{$bsn}', 
        '{$week}', 
        '{$tsn}'
        )";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $bsn_week_tsn = $xoopsDB->getInsertId();
        
        return $bsn_week_tsn;
    }


    //以流水號秀出某筆jill_equipment_week資料內容
    public static function show($bsn_week_tsn = '')
    {
        global $xoopsDB, $xoopsTpl;

        if(empty($bsn_week_tsn))
        {
            return;
        }

        $bsn_week_tsn = (int) $bsn_week_tsn;
        $all = self::get($bsn_week_tsn);

        $myts = \MyTextSanitizer::getInstance();
        //過濾讀出的變數值
        $all['bsn'] = (int) $all['bsn'];
        $all['week'] = (int) $all['week'];
        $all['tsn'] = (int) $all['tsn'];
    
        //以下會產生這些變數： $bsn, $week, $tsn
        foreach($all as $k => $v)
        {
            $$k = $v;
            $xoopsTpl->assign($k, $v);
        }

        

        $SweetAlert   = new SweetAlert();
        $SweetAlert->render('jill_equipment_week_destroy_func', "{$_SERVER['PHP_SELF']}?op=jill_equipment_week_destroy&bsn_week_tsn=", "bsn_week_tsn");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    }


    //更新jill_equipment_week某一筆資料
    public static function update($bsn_week_tsn = '')
    {
        global $xoopsDB, $xoopsUser;
        chk_is_adm();

        
        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();
        
        $bsn = (int) $_POST['bsn'];
        $week = (int) $_POST['week'];
        $tsn = (int) $_POST['tsn'];

        $sql = "update `" . $xoopsDB->prefix("jill_equipment_week") . "` set 
        `bsn` = '{$bsn}', 
        `week` = '{$week}', 
        `tsn` = '{$tsn}'
        where `bsn_week_tsn` = '$bsn_week_tsn'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        return $bsn_week_tsn;
    }


    //刪除jill_equipment_week某筆資料資料
    public static function destroy($bsn_week_tsn = '')
    {
        global $xoopsDB;
        chk_is_adm();

        if(empty($bsn_week_tsn))
        {
            return;
        }

        $sql = "delete from `" . $xoopsDB->prefix("jill_equipment_week") . "`
        where `bsn_week_tsn` = '{$bsn_week_tsn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
    }


    //以流水號取得某筆jill_equipment_week資料
    public static function get($bsn_week_tsn = '')
    {
        global $xoopsDB;

        if(empty($bsn_week_tsn))
        {
            return;
        }

        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_week") . "`
        where `bsn_week_tsn` = '{$bsn_week_tsn}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data = $xoopsDB->fetchArray($result);
        return $data;
    }


    //取得jill_equipment_week所有資料陣列
    public static function get_all()
    {
        global $xoopsDB;
        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_week") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while($data = $xoopsDB->fetchArray($result))
        {
            $bsn_week_tsn = $data['bsn_week_tsn'];
            $data_arr[$bsn_week_tsn] = $data;
        }
        return $data_arr;
    }


    //新增jill_equipment_week計數器
    public static function add_counter($bsn_week_tsn = '')
    {
        global $xoopsDB;

        if(empty($bsn_week_tsn))
        {
            return;
        }

        $sql = "update `" . $xoopsDB->prefix("jill_equipment_week") . "` set `` = `` + 1
        where `bsn_week_tsn` = '{$bsn_week_tsn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }


    //自動取得jill_equipment_week的最新排序
    public static function max_sort()
    {
        global $xoopsDB;
        $sql = "select max(``) from `" . $xoopsDB->prefix("jill_equipment_week") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($sort) = $xoopsDB->fetchRow($result);
        return ++$sort;
    }

}
