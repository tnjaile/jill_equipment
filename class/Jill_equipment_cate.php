<?php
namespace XoopsModules\Jill_equipment;

use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Jill_equipment\Jill_equipment_cate;
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\Ztree;
use XoopsModules\Jill_equipment\Jill_equipment_booking;

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


class Jill_equipment_cate
{
    //列出所有 jill_equipment_cate 資料
    public static function index()
    {
        global $xoopsDB, $xoopsTpl;

        $myts = \MyTextSanitizer::getInstance();
        
        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_cate") . "` order by `cate_sort`";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        $all_jill_equipment_cate = [];
        while($all = $xoopsDB->fetchArray($result))
        {
            //過濾讀出的變數值
            $all['cate_id'] = (int) $all['cate_id'];
            $all['cate_name'] = $myts->htmlSpecialChars($all['cate_name']);
            $all['cate_sort'] = (int) $all['cate_sort'];
    
            
            $all_jill_equipment_cate[] = $all;
        }

        //刪除確認的JS
        $SweetAlert   = new SweetAlert();
        $SweetAlert->render('jill_equipment_cate_destroy_func',
        "{$_SERVER['PHP_SELF']}?op=jill_equipment_cate_destroy&cate_id=", "cate_id");

        
        Utility::get_jquery(true);
        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
        $xoopsTpl->assign('all_jill_equipment_cate', $all_jill_equipment_cate);
    }


    //jill_equipment_cate編輯表單
    public static function create($cate_id = '' )
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;
        chk_is_adm();

        //抓取預設值
        $DBV = !empty($cate_id)? self::get($cate_id) : [];

        //預設值設定
        
        //設定 cate_id 欄位的預設值
        $cate_id = !isset($DBV['cate_id']) ? $cate_id : $DBV['cate_id'];
        $xoopsTpl->assign('cate_id', $cate_id);
        //設定 cate_name 欄位的預設值
        $cate_name = !isset($DBV['cate_name']) ? '' : $DBV['cate_name'];
        $xoopsTpl->assign('cate_name', $cate_name);
        //設定 cate_sort 欄位的預設值
        $cate_sort = !isset($DBV['cate_sort']) ? self::max_sort() : $DBV['cate_sort'];
        $xoopsTpl->assign('cate_sort', $cate_sort);

        $op = empty($cate_id) ? "jill_equipment_cate_store" : "jill_equipment_cate_update";

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


    //新增資料到jill_equipment_cate中
    public static function store()
    {
        global $xoopsDB, $xoopsUser;
        chk_is_adm();

        
        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();
        
        $cate_id = (int) $_POST['cate_id'];
        $cate_name = $myts->addSlashes($_POST['cate_name']);
        $cate_sort = (int) $_POST['cate_sort'];

        $sql = "insert into `" . $xoopsDB->prefix("jill_equipment_cate") . "` (
        `cate_name`, 
        `cate_sort`
        ) values(
        '{$cate_name}', 
        '{$cate_sort}'
        )";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $cate_id = $xoopsDB->getInsertId();
        
        return $cate_id;
    }


    //以流水號秀出某筆jill_equipment_cate資料內容
    public static function show($cate_id = '')
    {
        global $xoopsDB, $xoopsTpl;

        if(empty($cate_id))
        {
            return;
        }

        $cate_id = (int) $cate_id;
        $all = self::get($cate_id);

        $myts = \MyTextSanitizer::getInstance();
        //過濾讀出的變數值
        $all['cate_id'] = (int) $all['cate_id'];
        $all['cate_name'] = $myts->htmlSpecialChars($all['cate_name']);
        $all['cate_sort'] = (int) $all['cate_sort'];
    
        //以下會產生這些變數： $cate_name, $cate_sort
        foreach($all as $k => $v)
        {
            $$k = $v;
            $xoopsTpl->assign($k, $v);
        }

        

        $SweetAlert   = new SweetAlert();
        $SweetAlert->render('jill_equipment_cate_destroy_func', "{$_SERVER['PHP_SELF']}?op=jill_equipment_cate_destroy&cate_id=", "cate_id");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    }


    //更新jill_equipment_cate某一筆資料
    public static function update($cate_id = '')
    {
        global $xoopsDB, $xoopsUser;
        chk_is_adm();

        
        //XOOPS表單安全檢查
        Utility::xoops_security_check();

        $myts = \MyTextSanitizer::getInstance();
        
        $cate_id = (int) $_POST['cate_id'];
        $cate_name = $myts->addSlashes($_POST['cate_name']);
        $cate_sort = (int) $_POST['cate_sort'];

        $sql = "update `" . $xoopsDB->prefix("jill_equipment_cate") . "` set 
        `cate_name` = '{$cate_name}', 
        `cate_sort` = '{$cate_sort}'
        where `cate_id` = '$cate_id'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        return $cate_id;
    }


    //刪除jill_equipment_cate某筆資料資料
    public static function destroy($cate_id = '')
    {
        global $xoopsDB;
        chk_is_adm();

        if(empty($cate_id))
        {
            return;
        }

        $sql = "delete from `" . $xoopsDB->prefix("jill_equipment_cate") . "`
        where `cate_id` = '{$cate_id}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
    }


    //以流水號取得某筆jill_equipment_cate資料
    public static function get($cate_id = '')
    {
        global $xoopsDB;

        if(empty($cate_id))
        {
            return;
        }

        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_cate") . "`
        where `cate_id` = '{$cate_id}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data = $xoopsDB->fetchArray($result);
        return $data;
    }


    //取得jill_equipment_cate所有資料陣列
    public static function get_all()
    {
        global $xoopsDB;
        $sql = "select * from `" . $xoopsDB->prefix("jill_equipment_cate") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while($data = $xoopsDB->fetchArray($result))
        {
            $cate_id = $data['cate_id'];
            $data_arr[$cate_id] = $data;
        }
        return $data_arr;
    }


    //新增jill_equipment_cate計數器
    public static function add_counter($cate_id = '')
    {
        global $xoopsDB;

        if(empty($cate_id))
        {
            return;
        }

        $sql = "update `" . $xoopsDB->prefix("jill_equipment_cate") . "` set `` = `` + 1
        where `cate_id` = '{$cate_id}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }


    //自動取得jill_equipment_cate的最新排序
    public static function max_sort()
    {
        global $xoopsDB;
        $sql = "select max(`cate_sort`) from `" . $xoopsDB->prefix("jill_equipment_cate") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($sort) = $xoopsDB->fetchRow($result);
        return ++$sort;
    }


    //列出所有jill_equipment_cate資料
    public static function list_tree($def_cate_id = "")
    {
        global $xoopsDB, $xoopsTpl;

        $sql    = "select count(*),cate_id from " . $xoopsDB->prefix("jill_equipment_booking") . " group by cate_id";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $cate_count = [];
        while (list($count, $cate_id) = $xoopsDB->fetchRow($result)) {
            $cate_count[$cate_id] = $count;
        }

        $path     = self::get_path($def_cate_id);
        $path_arr = array_keys($path);
        $data[]   = "{ id:0, pId:0, name:'All', url:'main.php', target:'_self', open:true}";

        $sql    = "select cate_id, jill_equipment_cate_parent_sn, cate_name from " . $xoopsDB->prefix("jill_equipment_cate") . " order by cate_sort";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while (list($cate_id, $jill_equipment_cate_parent_sn, $cate_name) = $xoopsDB->fetchRow($result)) {
            $font_style      = $def_cate_id == $cate_id ? ", font:{'background-color':'yellow', 'color':'black'}" : '';
            $open            = in_array($cate_id, $path_arr) ? 'true' : 'false';
            $display_counter = empty($cate_count[$cate_id]) ? "" : " ({$cate_count[$cate_id]})";
            $data[]          = "{ id:{$cate_id}, pId:{$jill_equipment_cate_parent_sn}, name:'{$cate_name}{$display_counter}', url:'main.php?cate_id={$cate_id}', open: {$open} ,target:'_self' {$font_style}}";
        }

        $json = implode(",\n", $data);

        $ztree      = new Ztree("cate_tree", $json, "jill_equipment_cate_save_drag.php", "jill_equipment_cate_save_sort.php", "jill_equipment_cate_parent_sn", "cate_id");
        $ztree_code = $ztree->render();
        $xoopsTpl->assign('ztree_code', $ztree_code);
        $xoopsTpl->assign('cate_count', $cate_count);

        return $data;
    }

    //取得路徑
    public static function get_path($the_cate_id = "", $include_self = true)
    {
        global $xoopsDB;

        $arr[0]['cate_id']    = "0";
        $arr[0]['cate_name'] = "<i class='fa fa-home'></i>";
        $arr[0]['sub']        = self::get_sub(0);
        if (!empty($the_cate_id)) {

            $tbl = $xoopsDB->prefix("jill_equipment_cate");
            $sql = "SELECT t1.cate_id AS lev1, t2.cate_id as lev2, t3.cate_id as lev3, t4.cate_id as lev4, t5.cate_id as lev5, t6.cate_id as lev6, t7.cate_id as lev7
                FROM `{$tbl}` t1
                LEFT JOIN `{$tbl}` t2 ON t2.jill_equipment_cate_parent_sn = t1.cate_id
                LEFT JOIN `{$tbl}` t3 ON t3.jill_equipment_cate_parent_sn = t2.cate_id
                LEFT JOIN `{$tbl}` t4 ON t4.jill_equipment_cate_parent_sn = t3.cate_id
                LEFT JOIN `{$tbl}` t5 ON t5.jill_equipment_cate_parent_sn = t4.cate_id
                LEFT JOIN `{$tbl}` t6 ON t6.jill_equipment_cate_parent_sn = t5.cate_id
                LEFT JOIN `{$tbl}` t7 ON t7.jill_equipment_cate_parent_sn = t6.cate_id
                WHERE t1.jill_equipment_cate_parent_sn = '0'";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            while ($all = $xoopsDB->fetchArray($result)) {
                if (in_array($the_cate_id, $all)) {
                    //$main.="-";
                    foreach ($all as $cate_id) {
                        if (!empty($cate_id)) {
                            if (!$include_self and $cate_id == $the_cate_id) {
                                break;
                            }
                            $arr[$cate_id]        = self::get($cate_id);
                            $arr[$cate_id]['sub'] = self::get_sub($cate_id);
                            if ($cate_id == $the_cate_id) {
                                break;
                            }
                        }
                    }
                    //$main.="<br>";
                    break;
                }
            }
        }
        return $arr;
    }

    // 取得子分類陣列
    public static function get_sub($cate_id = "0")
    {
        global $xoopsDB;
        $sql = "select `cate_id`, `cate_name` from `" . $xoopsDB->prefix("jill_equipment_cate") . "` where `jill_equipment_cate_parent_sn` = '{$cate_id}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $cate_id_arr = [];
        while (list($cate_id, $cate_name) = $xoopsDB->fetchRow($result)) {
            $cate_id_arr[$cate_id] = $cate_name;
        }
        return $cate_id_arr;
    }

    //取得分類下的文件數
    public static function get_count()
    {
        global $xoopsDB;
        $sql = "select `cate_id`, count(*) from `" . $xoopsDB->prefix("jill_equipment_booking") . "` group by `cate_id`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $count_arr = [];
        while (list($cate_id, $count) = $xoopsDB->fetchRow($result)) {
            $count_arr[$cate_id] = $count;
        }
        return $count_arr;
    }

    //取得所有jill_equipment_cate分類選單的選項（模式 = edit or show,目前分類編號,目前分類的所屬編號）
    public static function get_options($page = '', $mode = 'edit', $default_cate_id = "0", $default_jill_equipment_cate_parent_sn = "0", $unselect_level = "", $start_search_sn = "0", $level = 0)
    {
        global $xoopsDB, $xoopsModule;

        $post_cate_arr = chk_cate_power('jill_equipment_booking_post');

        // $mod_id             = $xoopsModule->mid();
        // $moduleperm_handler = xoops_gethandler('groupperm');
        $count = self::get_count();

        $sql    = "select `cate_id`, `cate_name` from `" . $xoopsDB->prefix("jill_equipment_cate") . "` where `jill_equipment_cate_parent_sn` = '{$start_search_sn}' order by `cate_sort`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $prefix = str_repeat("&nbsp;&nbsp;", $level);
        $level++;

        $unselect = explode(",", $unselect_level);

        $main = "";
        while (list($cate_id, $cate_name) = $xoopsDB->fetchRow($result)) {

            if (!$_SESSION['jill_equipment_adm'] and !in_array($cate_id, $post_cate_arr)) {
                continue;
            }

            if ($mode == "edit") {
                $selected = ($cate_id == $default_jill_equipment_cate_parent_sn) ? "selected=selected" : "";
                $selected .= ($cate_id == $default_cate_id) ? "disabled=disabled" : "";
                $selected .= (in_array($level, $unselect)) ? "disabled=disabled" : "";
            } else {
                if (is_array($default_cate_id)) {
                    $selected = in_array($cate_id, $default_cate_id) ? "selected=selected" : "";
                } else {
                    $selected = ($cate_id == $default_cate_id) ? "selected=selected" : "";
                }
                $selected .= (in_array($level, $unselect)) ? "disabled=disabled" : "";
            }
            if ($page == "none" or empty($count[$cate_id])) {
                $counter = "";
            } else {
                $w       = ($page == "admin") ? _MA_TADLINK_CATE_COUNT : _MD_TADLINK_CATE_COUNT;
                $counter = " (" . sprintf($w, $count[$cate_id]) . ") ";
            }
            $main .= "<option value=$cate_id $selected>{$prefix}{$cate_name}{$counter}</option>";
            $main .= self::get_options($page, $mode, $default_cate_id, $default_jill_equipment_cate_parent_sn, $unselect_level, $cate_id, $level);

        }

        return $main;
    }

    
//更新排序
function update_jill_equipment_cate_sort(){
    global $xoopsDB;
    $sort = 1;
    foreach ($_POST['tr'] as $cate_id) {
        $sql="update ".$xoopsDB->prefix("jill_equipment_cate")." set `cate_sort`='{$sort}' where `cate_id`='{$cate_id}'";
        $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL." (".date("Y-m-d H:i:s").")");
        $sort++;
    }
    return _TAD_SORTED." (".date("Y-m-d H:i:s").")";
}

}
