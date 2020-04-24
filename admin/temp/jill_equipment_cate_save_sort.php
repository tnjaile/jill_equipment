<?php
require_once __DIR__ . '/header.php';

$sort = 1;
foreach ($_POST['tr'] as $cate_id) {
    $sql = "update `" . $xoopsDB->prefix("jill_equipment_cate") . "` set `cate_sort`='{$sort}' where `cate_id`='{$cate_id}'";
    $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")");
    $sort++;
}
echo _TAD_SORTED . " (" . date("Y-m-d H:i:s") . ")";
