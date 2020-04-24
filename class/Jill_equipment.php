<?php
namespace XoopsModules\Jill_equipment;

use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Jill_equipment\Jill_equipment;
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


class Jill_equipment
{
    //列出所有 jill_equipment 資料
    public static function index($cate_id = '')
    {
        global $xoopsDB, $xoopsTpl;

        $myts = \MyTextSanitizer::getInstance();
        
        $where_cate_id = empty($cate_id) ? '' : "where `cate_id` = '$cate_id'";
        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment") . "` {$where_cate_id} ";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        //取得分類所有資料陣列
        $jill_equipment_cate_arr = Jill_equipment_cate::get_all();
        $xoopsTpl->assign('jill_equipment_cate_arr', $jill_equipment_cate_arr);
    
        $all_jill_equipment = [];
        while($all = $xoopsDB->fetchArray($result))
        {
            //過濾讀出的變數值
            $all['sn'] = (int) $all['sn'];
            $all['cate_id'] = (int) $all['cate_id'];
            $all['title'] = $myts->htmlSpecialChars($all['title']);
            $all['desc'] = $myts->displayTarea($all['desc'], 1, 1, 0, 1, 0);
            $all['depositary'] = $myts->htmlSpecialChars($all['depositary']);
            $all['buying'] = $myts->htmlSpecialChars($all['buying']);
            $all['property_no'] = $myts->htmlSpecialChars($all['property_no']);
            $all['life_span'] = $myts->htmlSpecialChars($all['life_span']);
            $all['total'] = $myts->htmlSpecialChars($all['total']);
            $all['amount'] = $myts->htmlSpecialChars($all['amount']);
            $all['property_section'] = $myts->htmlSpecialChars($all['property_section']);
            $all['location'] = $myts->htmlSpecialChars($all['location']);
            $all['auditor'] = $myts->displayTarea($all['auditor'], 0, 1, 0, 1, 1);
    
            
            //取得分類標題
            $all['cate_id_title'] = $jill_equipment_cate_arr[$all['cate_id']]['cate_name'];
            $all_jill_equipment[] = $all;
        }

        //刪除確認的JS
        $SweetAlert   = new SweetAlert();
        $SweetAlert->render('jill_equipment_destroy_func',
        "{$_SERVER['PHP_SELF']}?op=jill_equipment_destroy&sn=", "sn");

        
        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
        $xoopsTpl->assign('all_jill_equipment', $all_jill_equipment);
    }


    //jill_equipment編輯表單
    public static function create($sn = '' , $cate_id = '')
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;
        chk_is_adm();

        //抓取預設值
        $DBV = !empty($sn)? self::get($sn) : [];

        //預設值設定
        
        //設定 sn 欄位的預設值
        $sn = !isset($DBV['sn']) ? $sn : $DBV['sn'];
        $xoopsTpl->assign('sn', $sn);
        //設定 cate_id 欄位的預設值
        $cate_id = !isset($DBV['cate_id']) ? $cate_id : $DBV['cate_id'];
        $xoopsTpl->assign('cate_id', $cate_id);
        //設定 title 欄位的預設值
        $title = !isset($DBV['title']) ? '' : $DBV['title'];
        $xoopsTpl->assign('title', $title);
        //設定 desc 欄位的預設值
        $desc = !isset($DBV['desc']) ? '' : $DBV['desc'];
        $xoopsTpl->assign('desc', $desc);
        //設定 depositary 欄位的預設值
        $depositary = !isset($DBV['depositary']) ? '' : $DBV['depositary'];
        $xoopsTpl->assign('depositary', $depositary);
        //設定 buying 欄位的預設值
        $buying = !isset($DBV['buying']) ? date("Y-m-d") : $DBV['buying'];
        $xoopsTpl->assign('buying', $buying);
        //設定 property_no 欄位的預設值
        $property_no = !isset($DBV['property_no']) ? '' : $DBV['property_no'];
        $xoopsTpl->assign('property_no', $property_no);
        //設定 life_span 欄位的預設值
        $life_span = !isset($DBV['life_span']) ? '' : $DBV['life_span'];
        $xoopsTpl->assign('life_span', $life_span);
        //設定 total 欄位的預設值
        $total = !isset($DBV['total']) ? '' : $DBV['total'];
        $xoopsTpl->assign('total', $total);
        //設定 amount 欄位的預設值
        $amount = !isset($DBV['amount']) ? '' : $DBV['amount'];
        $xoopsTpl->assign('amount', $amount);
        //設定 property_section 欄位的預設值
        $property_section = !isset($DBV['property_section']) ? '' : $DBV['property_section'];
        $xoopsTpl->assign('property_section', $property_section);
        //設定 location 欄位的預設值
        $location = !isset($DBV['location']) ? '' : $DBV['location'];
        $xoopsTpl->assign('location', $location);
        //設定 auditor 欄位的預設值
        $auditor = !isset($DBV['auditor']) ? '' : $DBV['auditor'];
        $xoopsTpl->assign('auditor', $auditor);

        $op = empty($sn) ? "jill_equipment_store" : "jill_equipment_update";

        //套用formValidator驗證機制
        $formValidator = new FormValidator("#myForm", true);
        $formValidator->render();

        
        //分類編號
        $sql = "select `cate_id`, `cate_name` from `".$xoopsDB->prefix("jill_equipment_cate")."` order by cate_sort";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $i=0;
        $cate_id_options_array = array();
        while(list($cate_id,$cate_name) = $xoopsDB->fetchRow($result)){
            $cate_id_options_array[$i]['cate_id']=$cate_id;
            $cate_id_options_array[$i]['cate_name']=$cate_name;
            $i++;
        }
        $xoopsTpl->assign("cate_id_options", $cate_id_options_array);
    //設備說明
        $ck = new CkEditor("jill_equipment","desc",$desc);
        $ck->setHeight(200);
        $editor = $ck->render();
        $xoopsTpl->assign('desc_editor', $editor);
    
    
        //加入Token安全機制
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token = new \XoopsFormHiddenToken();
        $token_form = $token->render();
        $xoopsTpl->assign("token_form", $token_form);
        $xoopsTpl->assign('action', $_SERVER["PHP_SELF"]);
        $xoopsTpl->assign('next_op', $op);
    }


    //新增資料到jill_equipment中
    public static function store()
    {
        global $xoopsDB, $xoopsUser;
        chk_is_adm();

        
        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();
        
        $sn = (int) $_POST['sn'];
        $cate_id = (int) $_POST['cate_id'];
        $title = $myts->addSlashes($_POST['title']);
        $desc = $myts->addSlashes($_POST['desc']);
        $depositary = $myts->addSlashes($_POST['depositary']);
        $buying = $myts->addSlashes($_POST['buying']);
        $property_no = $myts->addSlashes($_POST['property_no']);
        $life_span = $myts->addSlashes($_POST['life_span']);
        $total = $myts->addSlashes($_POST['total']);
        $amount = $myts->addSlashes($_POST['amount']);
        $property_section = $myts->addSlashes($_POST['property_section']);
        $location = $myts->addSlashes($_POST['location']);
        $auditor = $myts->addSlashes($_POST['auditor']);

        $sql = "insert into `" . $xoopsDB->prefix("jill_equipment") . "` (
        `cate_id`, 
        `title`, 
        `desc`, 
        `depositary`, 
        `buying`, 
        `property_no`, 
        `life_span`, 
        `total`, 
        `amount`, 
        `property_section`, 
        `location`, 
        `auditor`
        ) values(
        '{$cate_id}', 
        '{$title}', 
        '{$desc}', 
        '{$depositary}', 
        '{$buying}', 
        '{$property_no}', 
        '{$life_span}', 
        '{$total}', 
        '{$amount}', 
        '{$property_section}', 
        '{$location}', 
        '{$auditor}'
        )";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $sn = $xoopsDB->getInsertId();
        
        return $sn;
    }


    //以流水號秀出某筆jill_equipment資料內容
    public static function show($sn = '')
    {
        global $xoopsDB, $xoopsTpl;

        if(empty($sn))
        {
            return;
        }

        $sn = (int) $sn;
        $all = self::get($sn);

        $myts = \MyTextSanitizer::getInstance();
        //過濾讀出的變數值
        $all['sn'] = (int) $all['sn'];
        $all['cate_id'] = (int) $all['cate_id'];
        $all['title'] = $myts->htmlSpecialChars($all['title']);
        $all['desc'] = $myts->displayTarea($all['desc'], 1, 1, 0, 1, 0);
        $all['depositary'] = $myts->htmlSpecialChars($all['depositary']);
        $all['buying'] = $myts->htmlSpecialChars($all['buying']);
        $all['property_no'] = $myts->htmlSpecialChars($all['property_no']);
        $all['life_span'] = $myts->htmlSpecialChars($all['life_span']);
        $all['total'] = $myts->htmlSpecialChars($all['total']);
        $all['amount'] = $myts->htmlSpecialChars($all['amount']);
        $all['property_section'] = $myts->htmlSpecialChars($all['property_section']);
        $all['location'] = $myts->htmlSpecialChars($all['location']);
        $all['auditor'] = $myts->displayTarea($all['auditor'], 0, 1, 0, 1, 1);
    
        //以下會產生這些變數： $cate_id, $title, $desc, $depositary, $buying, $property_no, $life_span, $total, $amount, $property_section, $location, $auditor
        foreach($all as $k => $v)
        {
            $$k = $v;
            $xoopsTpl->assign($k, $v);
        }

        
        //取得分類資料(jill_equipment_cate)
        $jill_equipment_cate_arr = Jill_equipment_cate::get($cate_id);
        $xoopsTpl->assign('jill_equipment_cate_arr', $jill_equipment_cate_arr);
        $xoopsTpl->assign('cate_id_title', $jill_equipment_cate_arr['cate_name']);
    

        $SweetAlert   = new SweetAlert();
        $SweetAlert->render('jill_equipment_destroy_func', "{$_SERVER['PHP_SELF']}?op=jill_equipment_destroy&sn=", "sn");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    }


    //更新jill_equipment某一筆資料
    public static function update($sn = '')
    {
        global $xoopsDB, $xoopsUser;
        chk_is_adm();

        
        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();
        
        $sn = (int) $_POST['sn'];
        $cate_id = (int) $_POST['cate_id'];
        $title = $myts->addSlashes($_POST['title']);
        $desc = $myts->addSlashes($_POST['desc']);
        $depositary = $myts->addSlashes($_POST['depositary']);
        $buying = $myts->addSlashes($_POST['buying']);
        $property_no = $myts->addSlashes($_POST['property_no']);
        $life_span = $myts->addSlashes($_POST['life_span']);
        $total = $myts->addSlashes($_POST['total']);
        $amount = $myts->addSlashes($_POST['amount']);
        $property_section = $myts->addSlashes($_POST['property_section']);
        $location = $myts->addSlashes($_POST['location']);
        $auditor = $myts->addSlashes($_POST['auditor']);

        $sql = "update `" . $xoopsDB->prefix("jill_equipment") . "` set 
        `cate_id` = '{$cate_id}', 
        `title` = '{$title}', 
        `desc` = '{$desc}', 
        `depositary` = '{$depositary}', 
        `buying` = '{$buying}', 
        `property_no` = '{$property_no}', 
        `life_span` = '{$life_span}', 
        `total` = '{$total}', 
        `amount` = '{$amount}', 
        `property_section` = '{$property_section}', 
        `location` = '{$location}', 
        `auditor` = '{$auditor}'
        where `sn` = '$sn'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        return $sn;
    }


    //刪除jill_equipment某筆資料資料
    public static function destroy($sn = '')
    {
        global $xoopsDB;
        chk_is_adm();

        if(empty($sn))
        {
            return;
        }

        $sql = "delete from `" . $xoopsDB->prefix("jill_equipment") . "`
        where `sn` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
    }


    //以流水號取得某筆jill_equipment資料
    public static function get($sn = '')
    {
        global $xoopsDB;

        if(empty($sn))
        {
            return;
        }

        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment") . "`
        where `sn` = '{$sn}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data = $xoopsDB->fetchArray($result);
        return $data;
    }


    //取得jill_equipment所有資料陣列
    public static function get_all()
    {
        global $xoopsDB;
        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while($data = $xoopsDB->fetchArray($result))
        {
            $sn = $data['sn'];
            $data_arr[$sn] = $data;
        }
        return $data_arr;
    }


    //新增jill_equipment計數器
    public static function add_counter($sn = '')
    {
        global $xoopsDB;

        if(empty($sn))
        {
            return;
        }

        $sql = "update `" . $xoopsDB->prefix("jill_equipment") . "` set `` = `` + 1
        where `sn` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }


    //自動取得jill_equipment的最新排序
    public static function max_sort()
    {
        global $xoopsDB;
        $sql = "select max(``) from `" . $xoopsDB->prefix("jill_equipment") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($sort) = $xoopsDB->fetchRow($result);
        return ++$sort;
    }

}
