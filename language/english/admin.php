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

xoops_loadLanguage('admin_common', 'tadtools');

define("_MA_JILLEQUIPMENT_IMPORT", "Quickly import time period settings from template");
define("_MA_JILLEQUIPMENT_IMPORT_18", 'Quickly import "1 to 8 sessions" time period settings');
define("_MA_JILLEQUIPMENT_IMPORT_APM", 'Quickly import "morning and afternoon" time period settings');
define("_MA_JILLEQUIPMENT_IMPORT_TIME", 'Quickly import time period settings for "%s" (%s time period in total)');
define("_MA_JILLEQUIPMENT_N_TIME", "Section %s");
define("_MA_JILLEQUIPMENT_BOOKING_TIME", "I have been booked %s times and cannot be deleted");
define("_MA_JILLEQUIPMENT_AM", "AM");
define("_MA_JILLEQUIPMENT_PM", "PM");
define("_MA_JILLEQUIPMENT_ADD_TIME", "Add time period");
define("_MA_JILLEQUIPMENT_WEEK", "Open appointment day");
define("_MA_JILLEQUIPMENT_W0", "Sunday");
define("_MA_JILLEQUIPMENT_W1", "Monday");
define("_MA_JILLEQUIPMENT_W2", "Tuesday");
define("_MA_JILLEQUIPMENT_W3", "Wednesday");
define("_MA_JILLEQUIPMENT_W4", "Thursday");
define("_MA_JILLEQUIPMENT_W5", "Friday");
define("_MA_JILLEQUIPMENT_W6", "Saturday");
define('_MA_JILLEQUIPMENT_BOOKING_GROUP','Bookable groups');
define('_MA_JILLEQUIPMENT_SELECT_CATE','Please select a category first');
define('_MA_JILLEQUIPMENT_SN','Equipment number');
define('_MA_JILLEQUIPMENT_INFO','Device Management');
define('_MA_JILLEQUIPMENT_CATE_ID','Category ID');
define('_MA_JILLEQUIPMENT_TITLE','Device name');
define('_MA_JILLEQUIPMENT_DIRECTIONS','Equipment description');
define('_MA_JILLEQUIPMENT_TOTAL','Quantity');
define('_MA_JILLEQUIPMENT_AUDITOR','Auditable personnel');
define('_MA_JILLEQUIPMENT_AUDITOR_DESC','Please fill in the email when registering and separate with |. For example: aa@xx.xx|bb@xx.xx');
define('_MA_JILLEQUIPMENT_CATE_NAME','Category name');
define('_MA_JILLEQUIPMENT_CATE_SORT','Sort');
define('_MA_JILLEQUIPMENT_TSN','Time period number');
define('_MA_JILLEQUIPMENT_TIME_TITLE','Time period title');
define('_MA_JILLEQUIPMENT_TSORT','Sort by time period');
define('_MA_JILLEQUIPMENT_OPEN_WEEK','Open week');
define('_MA_JILLEQUIPMENT_TIMESET','Time period setting');
