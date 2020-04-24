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


//區塊主函式 (je_b_week_list)
function je_b_week_list($options){

    global $xoopsDB;

    //{$options[0]} : 伸縮頁籤
    $block['options0'] = $options[0] ?  $options[0] : 'accordion';

    $block['content']=$content;

    return $block;
}

//區塊編輯函式 (je_b_week_list_edit)
function je_b_week_list_edit($options){


    //$options[0] : "伸縮頁籤"預設值
    $selected_0_0 = ($options[0]=='accordion') ? 'selected' : '';
    $selected_0_1 = ($options[0]=='default') ? 'selected' : '';
    $selected_0_2 = ($options[0]=='vertical') ? 'selected' : '';

    $form="
    <ol class='my-form'>

        <!--伸縮頁籤-->
        <li class='my-row'>
            <lable class='my-label'>"._MB_JE_B_WEEK_LIST_OPT0."</lable>
            <div class='my-content'>
                <select name='options[0]' class='my-input'>
                    <option value='accordion' $selected_0_0>
                    accordion
                    </option>
                    <option value='default' $selected_0_1>
                    default
                    </option>
                    <option value='vertical' $selected_0_2>
                    vertical
                    </option>
                </select>
            </div>
        </li>
    </ol>
    ";
    return $form;
}
