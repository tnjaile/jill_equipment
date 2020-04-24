<?php
namespace XoopsModules\Jill_equipment;

use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Jill_equipment\Jill_equipment_time;
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


class Jill_equipment_time
{
    //列出所有 jill_equipment_time 資料
    public static function index($sn = '')
    {
        global $xoopsDB, $xoopsTpl;

        $myts = \MyTextSanitizer::getInstance();
        
        $where_sn = empty($sn) ? '' : "where `sn` = '$sn'";
        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_time") . "` {$where_sn} order by `tsort`";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        //取得分類所有資料陣列
        $jill_equipment_arr = Jill_equipment::get_all();
        $xoopsTpl->assign('jill_equipment_arr', $jill_equipment_arr);
    
        $all_jill_equipment_time = [];
        while($all = $xoopsDB->fetchArray($result))
        {
            //過濾讀出的變數值
            $all['tsn'] = (int) $all['tsn'];
            $all['sn'] = (int) $all['sn'];
            $all['title'] = $myts->htmlSpecialChars($all['title']);
            $all['tsort'] = (int) $all['tsort'];
            $all['open_week_arr'] = explode(';', $all['open_week']);
    
            
            //取得分類標題
            $all['sn_title'] = $jill_equipment_arr[$all['sn']]['title'];
            $all_jill_equipment_time[] = $all;
        }

        //刪除確認的JS
        $SweetAlert   = new SweetAlert();
        $SweetAlert->render('jill_equipment_time_destroy_func',
        "{$_SERVER['PHP_SELF']}?op=jill_equipment_time_destroy&tsn=", "tsn");

        
        Utility::get_jquery(true);
        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
        $xoopsTpl->assign('all_jill_equipment_time', $all_jill_equipment_time);
    }


    //jill_equipment_time編輯表單
    public static function create($tsn = '' , $sn = '')
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;
        chk_is_adm();

        //抓取預設值
        $DBV = !empty($tsn)? self::get($tsn) : [];

        //預設值設定
        
        //設定 tsn 欄位的預設值
        $tsn = !isset($DBV['tsn']) ? $tsn : $DBV['tsn'];
        $xoopsTpl->assign('tsn', $tsn);
        //設定 sn 欄位的預設值
        $sn = !isset($DBV['sn']) ? $sn : $DBV['sn'];
        $xoopsTpl->assign('sn', $sn);
        //設定 title 欄位的預設值
        $title = !isset($DBV['title']) ? '' : $DBV['title'];
        $xoopsTpl->assign('title', $title);
        //設定 tsort 欄位的預設值
        $tsort = !isset($DBV['tsort']) ? self::max_sort() : $DBV['tsort'];
        $xoopsTpl->assign('tsort', $tsort);
        //設定 open_week 欄位的預設值
        $open_week = !isset($DBV['open_week']) ? explode(';', '') : explode(';', $DBV['open_week']);
        $xoopsTpl->assign('open_week', $open_week);

        $op = empty($tsn) ? "jill_equipment_time_store" : "jill_equipment_time_update";

        //套用formValidator驗證機制
        $formValidator = new FormValidator("#myForm", true);
        $formValidator->render();

        
        //設備編號
        $sql = "select `sn`, `title` from `".$xoopsDB->prefix("jill_equipment")."` ";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $i=0;
        $sn_options_array = array();
        while(list($sn,$title) = $xoopsDB->fetchRow($result)){
            $sn_options_array[$i]['sn']=$sn;
            $sn_options_array[$i]['title']=$title;
            $i++;
        }
        $xoopsTpl->assign("sn_options", $sn_options_array);
    
    
        //加入Token安全機制
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token = new \XoopsFormHiddenToken();
        $token_form = $token->render();
        $xoopsTpl->assign("token_form", $token_form);
        $xoopsTpl->assign('action', $_SERVER["PHP_SELF"]);
        $xoopsTpl->assign('next_op', $op);
    }


    //新增資料到jill_equipment_time中
    public static function store()
    {
        global $xoopsDB, $xoopsUser;
        chk_is_adm();

        
        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();
        
        $tsn = (int) $_POST['tsn'];
        $sn = (int) $_POST['sn'];
        $title = $myts->addSlashes($_POST['title']);
        $tsort = (int) $_POST['tsort'];
        $open_week = implode(';', $_POST['open_week']);

        $sql = "insert into `" . $xoopsDB->prefix("jill_equipment_time") . "` (
        `sn`, 
        `title`, 
        `tsort`, 
        `open_week`
        ) values(
        '{$sn}', 
        '{$title}', 
        '{$tsort}', 
        '{$open_week}'
        )";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $tsn = $xoopsDB->getInsertId();
        
        return $tsn;
    }


    //以流水號秀出某筆jill_equipment_time資料內容
    public static function show($tsn = '')
    {
        global $xoopsDB, $xoopsTpl;

        if(empty($tsn))
        {
            return;
        }

        $tsn = (int) $tsn;
        $all = self::get($tsn);

        $myts = \MyTextSanitizer::getInstance();
        //過濾讀出的變數值
        $all['tsn'] = (int) $all['tsn'];
        $all['sn'] = (int) $all['sn'];
        $all['title'] = $myts->htmlSpecialChars($all['title']);
        $all['tsort'] = (int) $all['tsort'];
        $all['open_week_arr'] = explode(';', $all['open_week']);
    
        //以下會產生這些變數： $sn, $title, $tsort, $open_week
        foreach($all as $k => $v)
        {
            $$k = $v;
            $xoopsTpl->assign($k, $v);
        }

        
        //取得分類資料(jill_equipment)
        $jill_equipment_arr = Jill_equipment::get($sn);
        $xoopsTpl->assign('jill_equipment_arr', $jill_equipment_arr);
        $xoopsTpl->assign('sn_title', $jill_equipment_arr['title']);
    

        $SweetAlert   = new SweetAlert();
        $SweetAlert->render('jill_equipment_time_destroy_func', "{$_SERVER['PHP_SELF']}?op=jill_equipment_time_destroy&tsn=", "tsn");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    }


    //更新jill_equipment_time某一筆資料
    public static function update($tsn = '')
    {
        global $xoopsDB, $xoopsUser;
        chk_is_adm();

        
        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();
        
        $tsn = (int) $_POST['tsn'];
        $sn = (int) $_POST['sn'];
        $title = $myts->addSlashes($_POST['title']);
        $tsort = (int) $_POST['tsort'];
        $open_week = implode(';', $_POST['open_week']);

        $sql = "update `" . $xoopsDB->prefix("jill_equipment_time") . "` set 
        `sn` = '{$sn}', 
        `title` = '{$title}', 
        `tsort` = '{$tsort}', 
        `open_week` = '{$open_week}'
        where `tsn` = '$tsn'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        return $tsn;
    }


    //刪除jill_equipment_time某筆資料資料
    public static function destroy($tsn = '')
    {
        global $xoopsDB;
        chk_is_adm();

        if(empty($tsn))
        {
            return;
        }

        $sql = "delete from `" . $xoopsDB->prefix("jill_equipment_time") . "`
        where `tsn` = '{$tsn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
    }


    //以流水號取得某筆jill_equipment_time資料
    public static function get($tsn = '')
    {
        global $xoopsDB;

        if(empty($tsn))
        {
            return;
        }

        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_time") . "`
        where `tsn` = '{$tsn}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data = $xoopsDB->fetchArray($result);
        return $data;
    }


    //取得jill_equipment_time所有資料陣列
    public static function get_all()
    {
        global $xoopsDB;
        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_time") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while($data = $xoopsDB->fetchArray($result))
        {
            $tsn = $data['tsn'];
            $data_arr[$tsn] = $data;
        }
        return $data_arr;
    }


    //新增jill_equipment_time計數器
    public static function add_counter($tsn = '')
    {
        global $xoopsDB;

        if(empty($tsn))
        {
            return;
        }

        $sql = "update `" . $xoopsDB->prefix("jill_equipment_time") . "` set `` = `` + 1
        where `tsn` = '{$tsn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }


    //自動取得jill_equipment_time的最新排序
    public static function max_sort()
    {
        global $xoopsDB;
        $sql = "select max(`tsort`) from `" . $xoopsDB->prefix("jill_equipment_time") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($sort) = $xoopsDB->fetchRow($result);
        return ++$sort;
    }

}
