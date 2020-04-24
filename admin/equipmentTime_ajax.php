<?php
require_once __DIR__ . '/header.php';
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');

$op = system_CleanVars($_REQUEST, 'op', '', 'string');
switch ($op) {
    case 'change_enable':
        change_enable();
        break;

    case 'time_sort':
        time_sort();
        break;
    case 'save_title':
        save_title();
        break;
}

//改變啟用狀態
function change_enable()
{
    global $xoopsDB;
    $tsn  = (int) $_POST['tsn'];
    $week = (int) $_POST['week'];

    $sql             = "select `open_week` from `" . $xoopsDB->prefix("jill_equipment_time") . "` where `tsn` = '{$tsn}'";
    $result          = $xoopsDB->query($sql) or die("Reset Fail! (" . date("Y-m-d H:i:s") . ")");
    list($open_week) = $xoopsDB->fetchRow($result);
    $week_arr        = explode(',', $open_week);
    if (in_array($week, $week_arr)) {
        foreach ($week_arr as $w) {
            if ($w != $week) {
                $new_week[] = $w;
            }
        }
        $new_week = implode(',', $new_week);
        $new_pic  = "../images/no.gif";
    } else {
        $week_arr[] = $week;
        sort($week_arr);
        $new_week = implode(',', $week_arr);
        $new_pic  = "../images/yes.gif";
    }

    $sql = "update " . $xoopsDB->prefix("jill_equipment_time") . " set `open_week`='{$new_week}' where tsn='{$tsn}'";
    $xoopsDB->queryF($sql) or die("Reset Fail! (" . date("Y-m-d H:i:s") . ")");

    echo $new_pic;
}

// 排序
function time_sort()
{
    global $xoopsDB;
    $sort = 1;
    foreach ($_POST['tr'] as $tsn) {
        $sql = "update " . $xoopsDB->prefix("jill_equipment_time") . " set `tsort`='{$sort}' where `tsn`='{$tsn}'";
        $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")" . $sql);
        $sort++;
    }

    echo _TAD_SORTED . " (" . date("Y-m-d H:i:s") . ")";

}

// 編輯標題
function save_title()
{
    global $xoopsDB;
    $value          = system_CleanVars($_REQUEST, 'value', '', 'string');
    $id             = system_CleanVars($_REQUEST, 'id', '', 'string');
    list($col, $sn) = explode('_', $id);
    $sql            = "update " . $xoopsDB->prefix("jill_equipment_time") . " set $col='{$value}' where sn='{$sn}'";
    // die($sql);
    $xoopsDB->queryF($sql);
    echo $value;
}
