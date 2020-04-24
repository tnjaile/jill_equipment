<?php
require_once __DIR__ . '/header.php';

$sort = 1;
foreach ($_POST['tr'] as $bsn_week_tsn) {
    $sql = "update `" . $xoopsDB->prefix("jill_equipment_week") . "` set ``='{$sort}' where `bsn_week_tsn`='{$bsn_week_tsn}'";
    $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")");
    $sort++;
}
echo _TAD_SORTED . " (" . date("Y-m-d H:i:s") . ")";
