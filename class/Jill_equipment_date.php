<?php
namespace XoopsModules\Jill_equipment;

use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Jill_equipment\Jill_equipment_date;
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


class Jill_equipment_date
{
    //列出所有 jill_equipment_date 資料
    public static function index($tsn = '')
    {
        global $xoopsDB, $xoopsTpl;

        $myts = \MyTextSanitizer::getInstance();
        
        $where_tsn = empty($tsn) ? '' : "where `tsn` = '$tsn'";
        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_date") . "` {$where_tsn} ";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        //取得分類所有資料陣列
        $jill_equipment_time_arr = Jill_equipment_time::get_all();
        $xoopsTpl->assign('jill_equipment_time_arr', $jill_equipment_time_arr);
    
        $all_jill_equipment_date = [];
        while($all = $xoopsDB->fetchArray($result))
        {
            //過濾讀出的變數值
            $all['bsn'] = (int) $all['bsn'];
            $all['bdate'] = $myts->htmlSpecialChars($all['bdate']);
            $all['tsn'] = (int) $all['tsn'];
            $all['status'] = (int) $all['status'];
            $all['approver'] = (int) $all['approver'];
            $all['loan_date'] = $myts->htmlSpecialChars($all['loan_date']);
            $all['return_date'] = $myts->htmlSpecialChars($all['return_date']);
    
            
            //取得分類標題
            $all['tsn_title'] = $jill_equipment_time_arr[$all['tsn']]['title'];
            //將是否選項轉換為圖示
            $all['status_pic'] = $all['status']==1 ? '<img src="'.XOOPS_URL.'/modules/jill_equipment/images/yes.gif" alt="'._YES.'" title="'._YES.'">' : '<img src="'.XOOPS_URL.'/modules/jill_equipment/images/no.gif" alt="'._NO.'" title="'._NO.'">';
    
            //將 uid 編號轉換成使用者姓名（或帳號）
            $all['approver_name'] = \XoopsUser::getUnameFromId($all['approver'], 1);
            if(empty($all['approver_name']))$all['approver_name'] = \XoopsUser::getUnameFromId($all['approver'], 0);
            $all_jill_equipment_date[] = $all;
        }

        //刪除確認的JS
        $SweetAlert   = new SweetAlert();
        $SweetAlert->render('jill_equipment_date_destroy_func',
        "{$_SERVER['PHP_SELF']}?op=jill_equipment_date_destroy&bsn_bdate_tsn=", "bsn_bdate_tsn");

        
        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
        $xoopsTpl->assign('all_jill_equipment_date', $all_jill_equipment_date);
    }


    //jill_equipment_date編輯表單
    public static function create($bsn_bdate_tsn = '' , $tsn = '')
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;
        chk_is_adm();

        //抓取預設值
        $DBV = !empty($bsn_bdate_tsn)? self::get($bsn_bdate_tsn) : [];

        //預設值設定
        
        //設定 bsn 欄位的預設值
        $bsn = !isset($DBV['bsn']) ? $bsn : $DBV['bsn'];
        $xoopsTpl->assign('bsn', $bsn);
        //設定 bdate 欄位的預設值
        $bdate = !isset($DBV['bdate']) ? date("Y-m-d") : $DBV['bdate'];
        $xoopsTpl->assign('bdate', $bdate);
        //設定 tsn 欄位的預設值
        $tsn = !isset($DBV['tsn']) ? $tsn : $DBV['tsn'];
        $xoopsTpl->assign('tsn', $tsn);
        //設定 status 欄位的預設值
        $status = !isset($DBV['status']) ? '' : $DBV['status'];
        $xoopsTpl->assign('status', $status);
        //設定 approver 欄位的預設值
        $user_uid = $xoopsUser ? $xoopsUser->uid() : "";
        $approver = !isset($DBV['approver']) ? $user_uid : $DBV['approver'];
        $xoopsTpl->assign('approver', $approver);
        //設定 loan_date 欄位的預設值
        $loan_date = !isset($DBV['loan_date']) ? date("Y-m-d H:i:s") : $DBV['loan_date'];
        $xoopsTpl->assign('loan_date', $loan_date);
        //設定 return_date 欄位的預設值
        $return_date = !isset($DBV['return_date']) ? date("Y-m-d H:i:s") : $DBV['return_date'];
        $xoopsTpl->assign('return_date', $return_date);

        $op = empty($bsn_bdate_tsn) ? "jill_equipment_date_store" : "jill_equipment_date_update";

        //套用formValidator驗證機制
        $formValidator = new FormValidator("#myForm", true);
        $formValidator->render();

        
        //時段編號
        $sql = "select `tsn`, `title` from `".$xoopsDB->prefix("jill_equipment_time")."` order by tsort";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $i=0;
        $tsn_options_array = array();
        while(list($tsn,$title) = $xoopsDB->fetchRow($result)){
            $tsn_options_array[$i]['tsn']=$tsn;
            $tsn_options_array[$i]['title']=$title;
            $i++;
        }
        $xoopsTpl->assign("tsn_options", $tsn_options_array);
    
    
        //加入Token安全機制
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token = new \XoopsFormHiddenToken();
        $token_form = $token->render();
        $xoopsTpl->assign("token_form", $token_form);
        $xoopsTpl->assign('action', $_SERVER["PHP_SELF"]);
        $xoopsTpl->assign('next_op', $op);
    }


    //新增資料到jill_equipment_date中
    public static function store()
    {
        global $xoopsDB, $xoopsUser;
        chk_is_adm();

        
        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();
        
        $bsn = (int) $_POST['bsn'];
        $bdate = $myts->addSlashes($_POST['bdate']);
        $tsn = (int) $_POST['tsn'];
        $status = (int) $_POST['status'];
        $approver = (int) $_POST['approver'];
        $loan_date = date("Y-m-d H:i:s",xoops_getUserTimestamp(time()));
        $return_date = date("Y-m-d H:i:s",xoops_getUserTimestamp(time()));

        $sql = "insert into `" . $xoopsDB->prefix("jill_equipment_date") . "` (
        `bsn`, 
        `bdate`, 
        `tsn`, 
        `status`, 
        `approver`, 
        `loan_date`, 
        `return_date`
        ) values(
        '{$bsn}', 
        '{$bdate}', 
        '{$tsn}', 
        '{$status}', 
        '{$approver}', 
        '{$loan_date}', 
        '{$return_date}'
        )";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $bsn_bdate_tsn = $xoopsDB->getInsertId();
        
        return $bsn_bdate_tsn;
    }


    //以流水號秀出某筆jill_equipment_date資料內容
    public static function show($bsn_bdate_tsn = '')
    {
        global $xoopsDB, $xoopsTpl;

        if(empty($bsn_bdate_tsn))
        {
            return;
        }

        $bsn_bdate_tsn = (int) $bsn_bdate_tsn;
        $all = self::get($bsn_bdate_tsn);

        $myts = \MyTextSanitizer::getInstance();
        //過濾讀出的變數值
        $all['bsn'] = (int) $all['bsn'];
        $all['bdate'] = $myts->htmlSpecialChars($all['bdate']);
        $all['tsn'] = (int) $all['tsn'];
        $all['status'] = (int) $all['status'];
        $all['approver'] = (int) $all['approver'];
        $all['loan_date'] = $myts->htmlSpecialChars($all['loan_date']);
        $all['return_date'] = $myts->htmlSpecialChars($all['return_date']);
    
        //以下會產生這些變數： $bsn, $bdate, $tsn, $status, $approver, $loan_date, $return_date
        foreach($all as $k => $v)
        {
            $$k = $v;
            $xoopsTpl->assign($k, $v);
        }

        
        //取得分類資料(jill_equipment_time)
        $jill_equipment_time_arr = Jill_equipment_time::get($tsn);
        $xoopsTpl->assign('jill_equipment_time_arr', $jill_equipment_time_arr);
        $xoopsTpl->assign('tsn_title', $jill_equipment_time_arr['title']);
    
        //將是否選項轉換為圖示
        $status_pic = ($status==1)? '<img src="'.XOOPS_URL.'/modules/jill_equipment/images/yes.gif" alt="'._YES.'" title="'._YES.'">' : '<img src="'.XOOPS_URL.'/modules/jill_equipment/images/no.gif" alt="'._NO.'" title="'._NO.'">';
        $xoopsTpl->assign('status_pic', $status_pic);
    
        //將 uid 編號轉換成使用者姓名（或帳號）
        $approver_name = \XoopsUser::getUnameFromId($approver, 1);
        if(empty($approver_name)) $approver_name = \XoopsUser::getUnameFromId($approver , 0);
        $xoopsTpl->assign('approver_name', $approver_name);
    

        $SweetAlert   = new SweetAlert();
        $SweetAlert->render('jill_equipment_date_destroy_func', "{$_SERVER['PHP_SELF']}?op=jill_equipment_date_destroy&bsn_bdate_tsn=", "bsn_bdate_tsn");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    }


    //更新jill_equipment_date某一筆資料
    public static function update($bsn_bdate_tsn = '')
    {
        global $xoopsDB, $xoopsUser;
        chk_is_adm();

        
        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();
        
        $bsn = (int) $_POST['bsn'];
        $bdate = $myts->addSlashes($_POST['bdate']);
        $tsn = (int) $_POST['tsn'];
        $status = (int) $_POST['status'];
        $approver = (int) $_POST['approver'];
        $loan_date = date("Y-m-d H:i:s",xoops_getUserTimestamp(time()));
        $return_date = date("Y-m-d H:i:s",xoops_getUserTimestamp(time()));

        $sql = "update `" . $xoopsDB->prefix("jill_equipment_date") . "` set 
        `bsn` = '{$bsn}', 
        `bdate` = '{$bdate}', 
        `tsn` = '{$tsn}', 
        `status` = '{$status}', 
        `approver` = '{$approver}', 
        `loan_date` = '{$loan_date}', 
        `return_date` = '{$return_date}'
        where `bsn_bdate_tsn` = '$bsn_bdate_tsn'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        return $bsn_bdate_tsn;
    }


    //刪除jill_equipment_date某筆資料資料
    public static function destroy($bsn_bdate_tsn = '')
    {
        global $xoopsDB;
        chk_is_adm();

        if(empty($bsn_bdate_tsn))
        {
            return;
        }

        $sql = "delete from `" . $xoopsDB->prefix("jill_equipment_date") . "`
        where `bsn_bdate_tsn` = '{$bsn_bdate_tsn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
    }


    //以流水號取得某筆jill_equipment_date資料
    public static function get($bsn_bdate_tsn = '')
    {
        global $xoopsDB;

        if(empty($bsn_bdate_tsn))
        {
            return;
        }

        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_date") . "`
        where `bsn_bdate_tsn` = '{$bsn_bdate_tsn}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data = $xoopsDB->fetchArray($result);
        return $data;
    }


    //取得jill_equipment_date所有資料陣列
    public static function get_all()
    {
        global $xoopsDB;
        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_date") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while($data = $xoopsDB->fetchArray($result))
        {
            $bsn_bdate_tsn = $data['bsn_bdate_tsn'];
            $data_arr[$bsn_bdate_tsn] = $data;
        }
        return $data_arr;
    }


    //新增jill_equipment_date計數器
    public static function add_counter($bsn_bdate_tsn = '')
    {
        global $xoopsDB;

        if(empty($bsn_bdate_tsn))
        {
            return;
        }

        $sql = "update `" . $xoopsDB->prefix("jill_equipment_date") . "` set `` = `` + 1
        where `bsn_bdate_tsn` = '{$bsn_bdate_tsn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }


    //自動取得jill_equipment_date的最新排序
    public static function max_sort()
    {
        global $xoopsDB;
        $sql = "select max(``) from `" . $xoopsDB->prefix("jill_equipment_date") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($sort) = $xoopsDB->fetchRow($result);
        return ++$sort;
    }

}
