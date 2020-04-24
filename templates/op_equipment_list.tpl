<h2 class="text-center"><a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php"><i class="fa fa-reply" aria-hidden="true"></i>  <{$OneCate.cate_name}><{$smarty.const._MA_JILLEQUIPMENT_INFO}></a></h2>
<{if $AllEquipment}>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <!--設備名稱-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_TITLE}>
                </th>
                <!--數量-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_TOTAL}>
                </th>
                <!--可審核人員-->
                <th><{$smarty.const._MA_JILLEQUIPMENT_AUDITOR}></th>
                <th><{$smarty.const._MA_JILLEQUIPMENT_BOOKING_GROUP}></th>

                <{if $smarty.session.jill_equipment_adm}>
                    <th><{$smarty.const._TAD_FUNCTION}></th>
                <{/if}>
            </tr>
        </thead>

        <tbody id="jill_equipment_sort">
            <{foreach from=$AllEquipment item=data}>
                <tr id="tr_<{$data.sn}>">
                        <!--設備名稱-->
                        <td>
                            <a href="<{$action}>?sn=<{$data.sn}>">
                                <{$data.title}></a>
                        </td>
                        <!--數量-->
                        <td>
                            <{$data.total}>
                        </td>
                        <!--可審核人員-->
                        <td>
                            <{$data.auditor}>
                        </td>
                        <!--可預約群組-->
                        <td>
                            <{$data.booking_name}>
                        </td>

                        <{if $smarty.session.jill_equipment_adm}>
                            <td nowrap>
                                <a href="javascript:equipment_destroy_func(<{$data.sn}>);" class="btn btn-sm btn-danger" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash-o"></i></a>
                                <a href="<{$action}>?op=equipment_form&sn=<{$data.sn}>" class="btn btn-sm btn-warning" title="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil"></i></a>
                                <a href="<{$xoops_url}>/modules/jill_equipment/admin/equipmentTime.php?sn=<{$data.sn}>" class="btn btn-sm btn-primary"><{$smarty.const._MA_JILLEQUIPMENT_TIMESET}></a>
                            </td>
                        <{/if}>
                </tr>
            <{/foreach}>
        </tbody>
    </table>
    <{includeq file="$xoops_rootpath/modules/jill_equipment/templates/snippet_page.tpl"}>
    <{if $smarty.session.jill_equipment_adm}>
        <div class="text-right">
            <a href="<{$action}>?op=equipment_form&cate_id=<{$OneCate.cate_id}>" class="btn btn-info">
            <i class="fa fa-plus"></i> <{$smarty.const._TAD_ADD}>
            </a>
            <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php" class="btn btn-success"><{$smarty.const._MD_JILLEQUIPMENT_BACK}></a>
        </div>
    <{/if}>
<{else}>
    <div class="jumbotron text-center">
        <{if $smarty.session.jill_equipment_adm}>
            <a href="<{$action}>?op=equipment_form&cate_id=<{$OneCate.cate_id}>" class="btn btn-info">
            <i class="fa fa-plus"></i> <{$smarty.const._TAD_ADD}>
            </a>
        <{else}>
            <h3><{$smarty.const._TAD_EMPTY}></h3>
        <{/if}>
        <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php" class="btn btn-success"><{$smarty.const._MD_JILLEQUIPMENT_BACK}></a>
    </div>
<{/if}>
