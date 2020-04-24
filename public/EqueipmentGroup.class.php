<?php
//群組類
class EquipmentGroup
{
    //檢查是否具有預約權限
    public static function group_perm($_haystack_groups)
    {
        global $xoopsUser;
        $_haystack_groups = json_decode($_haystack_groups, true);
        if ($xoopsUser) {
            if ($_SESSION['jill_equipment_adm']) {
                return true;
                exit;
            }

            $_needle_groups = array_unique($xoopsUser->groups());

            foreach ($_needle_groups as $key => $group) {
                if (in_array($group, $_haystack_groups)) {
                    return true;
                }
            }
        } else {
            // 訪客可讀取
            if (in_array(3, $_haystack_groups)) {
                return true;
            }
        }
        return false;
    }
}
