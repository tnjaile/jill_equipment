<{if $all_jill_equipment}>
    <{if $smarty.session.jill_equipment_adm}>

    <{/if}>

    <div id="jill_equipment_save_msg"></div>

    <table class="table table-striped table-hover">
        <thead>
            <tr class="info">

                <!--分類編號-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_CATE_ID}>
                </th>
                <!--設備名稱-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_TITLE}>
                </th>
                <!--保管人-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_DEPOSITARY}>
                </th>
                <!--購置日期-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_BUYING}>
                </th>
                <!--財產編號-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_PROPERTY_NO}>
                </th>
                <!--年限-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_LIFE_SPAN}>
                </th>
                <!--數量-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_TOTAL}>
                </th>
                <!--可借數量-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_AMOUNT}>
                </th>
                <!--保管單位-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_PROPERTY_SECTION}>
                </th>
                <!--目前所在位置-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_LOCATION}>
                </th>
                <{if $smarty.session.jill_equipment_adm}>
                    <th><{$smarty.const._TAD_FUNCTION}></th>
                <{/if}>
            </tr>
        </thead>

        <tbody id="jill_equipment_sort">
            <{foreach from=$all_jill_equipment item=data}>
                <tr id="tr_<{$data.sn}>">

                        <!--分類編號-->
                        <td>
                            <a href="<{$xoops_url}>/modules/jill_equipment?cate_id=<{$data.cate_id}>">
                <{$data.cate_id_title}>
                </a>
                        </td>

                        <!--設備名稱-->
                        <td>
                            <a href="<{$xoops_url}>/modules/jill_equipment?sn=<{$data.sn}>">
                <{$data.title}>
                </a>
                        </td>

                        <!--保管人-->
                        <td>
                            <{$data.depositary}>
                        </td>

                        <!--購置日期-->
                        <td>
                            <{$data.buying}>
                        </td>

                        <!--財產編號-->
                        <td>
                            <{$data.property_no}>
                        </td>

                        <!--年限-->
                        <td>
                            <{$data.life_span}>
                        </td>

                        <!--數量-->
                        <td>
                            <{$data.total}>
                        </td>

                        <!--可借數量-->
                        <td>
                            <{$data.amount}>
                        </td>

                        <!--保管單位-->
                        <td>
                            <{$data.property_section}>
                        </td>

                        <!--目前所在位置-->
                        <td>
                            <{$data.location}>
                        </td>

                    <{if $smarty.session.jill_equipment_adm}>
                        <td nowrap>
                            <a href="javascript:jill_equipment_destroy_func(<{$data.sn}>);" class="btn btn-sm btn-danger" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash-o"></i></a>
                            <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_edit&sn=<{$data.sn}>" class="btn btn-sm btn-warning" title="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil"></i></a>

                        </td>
                    <{/if}>
                </tr>
            <{/foreach}>
        </tbody>
    </table>


    <{if $smarty.session.jill_equipment_adm}>
        <div class="text-right">
            <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_create&cate_id=<{$cate_id}>" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        </div>
    <{/if}>

    <{$bar}>
<{else}>
    <div class="jumbotron text-center">
        <{if $smarty.session.jill_equipment_adm}>
            <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_create&cate_id=<{$cate_id}>" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        <{else}>
            <h3><{$smarty.const._TAD_EMPTY}></h3>
        <{/if}>
    </div>
<{/if}>
