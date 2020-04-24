<?php
namespace XoopsModules\Jill_equipment;

use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Jill_equipment\Jill_equipment_booking;
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


class Jill_equipment_booking
{
    //列出所有 jill_equipment_booking 資料
    public static function index()
    {
        global $xoopsDB, $xoopsTpl;

        $myts = \MyTextSanitizer::getInstance();
        
        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_booking") . "` ";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        $all_jill_equipment_booking = [];
        while($all = $xoopsDB->fetchArray($result))
        {
            //過濾讀出的變數值
            $all['bsn'] = (int) $all['bsn'];
            $all['buid'] = (int) $all['buid'];
            $all['booking_time'] = $myts->htmlSpecialChars($all['booking_time']);
            $all['booking_content'] = $myts->displayTarea($all['booking_content'], 0, 1, 0, 1, 1);
            $all['place'] = $myts->htmlSpecialChars($all['place']);
            $all['start'] = $myts->htmlSpecialChars($all['start']);
            $all['end'] = $myts->htmlSpecialChars($all['end']);
    
            
            //將 uid 編號轉換成使用者姓名（或帳號）
            $all['buid_name'] = \XoopsUser::getUnameFromId($all['buid'], 1);
            if(empty($all['buid_name']))$all['buid_name'] = \XoopsUser::getUnameFromId($all['buid'], 0);
            $all_jill_equipment_booking[] = $all;
        }

        //刪除確認的JS
        $SweetAlert   = new SweetAlert();
        $SweetAlert->render('jill_equipment_booking_destroy_func',
        "{$_SERVER['PHP_SELF']}?op=jill_equipment_booking_destroy&bsn=", "bsn");

        
        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
        $xoopsTpl->assign('all_jill_equipment_booking', $all_jill_equipment_booking);
    }


    //jill_equipment_booking編輯表單
    public static function create($bsn = '' )
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;
        chk_is_adm();

        //抓取預設值
        $DBV = !empty($bsn)? self::get($bsn) : [];

        //預設值設定
        
        //設定 bsn 欄位的預設值
        $bsn = !isset($DBV['bsn']) ? $bsn : $DBV['bsn'];
        $xoopsTpl->assign('bsn', $bsn);
        //設定 buid 欄位的預設值
        $user_uid = $xoopsUser ? $xoopsUser->uid() : "";
        $buid = !isset($DBV['buid']) ? $user_uid : $DBV['buid'];
        $xoopsTpl->assign('buid', $buid);
        //設定 booking_time 欄位的預設值
        $booking_time = !isset($DBV['booking_time']) ? date("Y-m-d H:i:s") : $DBV['booking_time'];
        $xoopsTpl->assign('booking_time', $booking_time);
        //設定 booking_content 欄位的預設值
        $booking_content = !isset($DBV['booking_content']) ? '' : $DBV['booking_content'];
        $xoopsTpl->assign('booking_content', $booking_content);
        //設定 place 欄位的預設值
        $place = !isset($DBV['place']) ? '' : $DBV['place'];
        $xoopsTpl->assign('place', $place);
        //設定 start 欄位的預設值
        $start = !isset($DBV['start']) ? date("Y-m-d") : $DBV['start'];
        $xoopsTpl->assign('start', $start);
        //設定 end 欄位的預設值
        $end = !isset($DBV['end']) ? date("Y-m-d") : $DBV['end'];
        $xoopsTpl->assign('end', $end);

        $op = empty($bsn) ? "jill_equipment_booking_store" : "jill_equipment_booking_update";

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


    //新增資料到jill_equipment_booking中
    public static function store()
    {
        global $xoopsDB, $xoopsUser;
        chk_is_adm();

        
        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();
        
        $bsn = (int) $_POST['bsn'];
        $buid = (int) $_POST['buid'];
        $booking_time = date("Y-m-d H:i:s",xoops_getUserTimestamp(time()));
        $booking_content = $myts->addSlashes($_POST['booking_content']);
        $place = $myts->addSlashes($_POST['place']);
        $start = $myts->addSlashes($_POST['start']);
        $end = $myts->addSlashes($_POST['end']);

        $sql = "insert into `" . $xoopsDB->prefix("jill_equipment_booking") . "` (
        `buid`, 
        `booking_time`, 
        `booking_content`, 
        `place`, 
        `start`, 
        `end`
        ) values(
        '{$buid}', 
        '{$booking_time}', 
        '{$booking_content}', 
        '{$place}', 
        '{$start}', 
        '{$end}'
        )";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $bsn = $xoopsDB->getInsertId();
        
        return $bsn;
    }


    //以流水號秀出某筆jill_equipment_booking資料內容
    public static function show($bsn = '')
    {
        global $xoopsDB, $xoopsTpl;

        if(empty($bsn))
        {
            return;
        }

        $bsn = (int) $bsn;
        $all = self::get($bsn);

        $myts = \MyTextSanitizer::getInstance();
        //過濾讀出的變數值
        $all['bsn'] = (int) $all['bsn'];
        $all['buid'] = (int) $all['buid'];
        $all['booking_time'] = $myts->htmlSpecialChars($all['booking_time']);
        $all['booking_content'] = $myts->displayTarea($all['booking_content'], 0, 1, 0, 1, 1);
        $all['place'] = $myts->htmlSpecialChars($all['place']);
        $all['start'] = $myts->htmlSpecialChars($all['start']);
        $all['end'] = $myts->htmlSpecialChars($all['end']);
    
        //以下會產生這些變數： $buid, $booking_time, $booking_content, $place, $start, $end
        foreach($all as $k => $v)
        {
            $$k = $v;
            $xoopsTpl->assign($k, $v);
        }

        
        //將 uid 編號轉換成使用者姓名（或帳號）
        $buid_name = \XoopsUser::getUnameFromId($buid, 1);
        if(empty($buid_name)) $buid_name = \XoopsUser::getUnameFromId($buid , 0);
        $xoopsTpl->assign('buid_name', $buid_name);
    

        $SweetAlert   = new SweetAlert();
        $SweetAlert->render('jill_equipment_booking_destroy_func', "{$_SERVER['PHP_SELF']}?op=jill_equipment_booking_destroy&bsn=", "bsn");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    }


    //更新jill_equipment_booking某一筆資料
    public static function update($bsn = '')
    {
        global $xoopsDB, $xoopsUser;
        chk_is_adm();

        
        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();
        
        $bsn = (int) $_POST['bsn'];
        $buid = (int) $_POST['buid'];
        $booking_time = date("Y-m-d H:i:s",xoops_getUserTimestamp(time()));
        $booking_content = $myts->addSlashes($_POST['booking_content']);
        $place = $myts->addSlashes($_POST['place']);
        $start = $myts->addSlashes($_POST['start']);
        $end = $myts->addSlashes($_POST['end']);

        $sql = "update `" . $xoopsDB->prefix("jill_equipment_booking") . "` set 
        `buid` = '{$buid}', 
        `booking_time` = '{$booking_time}', 
        `booking_content` = '{$booking_content}', 
        `place` = '{$place}', 
        `start` = '{$start}', 
        `end` = '{$end}'
        where `bsn` = '$bsn'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        return $bsn;
    }


    //刪除jill_equipment_booking某筆資料資料
    public static function destroy($bsn = '')
    {
        global $xoopsDB;
        chk_is_adm();

        if(empty($bsn))
        {
            return;
        }

        $sql = "delete from `" . $xoopsDB->prefix("jill_equipment_booking") . "`
        where `bsn` = '{$bsn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
    }


    //以流水號取得某筆jill_equipment_booking資料
    public static function get($bsn = '')
    {
        global $xoopsDB;

        if(empty($bsn))
        {
            return;
        }

        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_booking") . "`
        where `bsn` = '{$bsn}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data = $xoopsDB->fetchArray($result);
        return $data;
    }


    //取得jill_equipment_booking所有資料陣列
    public static function get_all()
    {
        global $xoopsDB;
        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_booking") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while($data = $xoopsDB->fetchArray($result))
        {
            $bsn = $data['bsn'];
            $data_arr[$bsn] = $data;
        }
        return $data_arr;
    }


    //新增jill_equipment_booking計數器
    public static function add_counter($bsn = '')
    {
        global $xoopsDB;

        if(empty($bsn))
        {
            return;
        }

        $sql = "update `" . $xoopsDB->prefix("jill_equipment_booking") . "` set `` = `` + 1
        where `bsn` = '{$bsn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }


    //自動取得jill_equipment_booking的最新排序
    public static function max_sort()
    {
        global $xoopsDB;
        $sql = "select max(``) from `" . $xoopsDB->prefix("jill_equipment_booking") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($sort) = $xoopsDB->fetchRow($result);
        return ++$sort;
    }

}
