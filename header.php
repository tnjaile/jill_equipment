<?php
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

$interface_menu[_TAD_TO_MOD] = "index.php";
$interface_icon[_TAD_TO_MOD] = "fa-chevron-right";

if ($xoopsUser) {
    $module_id = $xoopsModule->getVar('mid');

    //判斷是否對該模組有管理權限
    if (!isset($_SESSION['jill_equipment_adm'])) {
        $_SESSION['jill_equipment_adm'] = $xoopsUser->isAdmin($module_id);
    }

    if ($_SESSION['jill_equipment_adm']) {
        $interface_menu[_TAD_TO_ADMIN] = "admin/main.php";
        $interface_icon[_TAD_TO_ADMIN] = "fa-sign-in";
    }

} else {
    unset($_SESSION['jill_equipment_adm']);
}
