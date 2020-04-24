<{if $all_jill_equipment_booking}>
    <{if $smarty.session.jill_equipment_adm}>
        
    <{/if}>

    <div id="jill_equipment_booking_save_msg"></div>

    <table class="table table-striped table-hover">
        <thead>
            <tr class="info">
                
                <!--預約者-->
                <th>
                    <{$smarty.const._MD_JILLEQUIPMENT_BUID}>
                </th>
                <!--預約時間-->
                <th>
                    <{$smarty.const._MD_JILLEQUIPMENT_BOOKING_TIME}>
                </th>
                <!--使用地點-->
                <th>
                    <{$smarty.const._MD_JILLEQUIPMENT_PLACE}>
                </th>
                <!--開始日期-->
                <th>
                    <{$smarty.const._MD_JILLEQUIPMENT_START}>
                </th>
                <!--預定歸還日期-->
                <th>
                    <{$smarty.const._MD_JILLEQUIPMENT_END}>
                </th>
                <{if $smarty.session.jill_equipment_adm}>
                    <th><{$smarty.const._TAD_FUNCTION}></th>
                <{/if}>
            </tr>
        </thead>

        <tbody id="jill_equipment_booking_sort">
            <{foreach from=$all_jill_equipment_booking item=data}>
                <tr id="tr_<{$data.bsn}>">
                    
                        <!--預約者-->
                        <td>
                            <a href="<{$xoops_user}>/user.php?uid=<{$data.buid}>"><{$data.buid_name}></a>
                        </td>

                        <!--預約時間-->
                        <td>
                            <{$data.booking_time}>
                        </td>

                        <!--使用地點-->
                        <td>
                            <{$data.place}>
                        </td>

                        <!--開始日期-->
                        <td>
                            <{$data.start}>
                        </td>

                        <!--預定歸還日期-->
                        <td>
                            <{$data.end}>
                        </td>

                    <{if $smarty.session.jill_equipment_adm}>
                        <td nowrap>
                            <a href="javascript:jill_equipment_booking_destroy_func(<{$data.bsn}>);" class="btn btn-sm btn-danger" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash-o"></i></a>
                            <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_booking_edit&bsn=<{$data.bsn}>" class="btn btn-sm btn-warning" title="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil"></i></a>
                            
                        </td>
                    <{/if}>
                </tr>
            <{/foreach}>
        </tbody>
    </table>


    <{if $smarty.session.jill_equipment_adm}>
        <div class="text-right">
            <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_booking_create" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        </div>
    <{/if}>

    <{$bar}>
<{else}>
    <div class="jumbotron text-center">
        <{if $smarty.session.jill_equipment_adm}>
            <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_booking_create" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        <{else}>
            <h3><{$smarty.const._TAD_EMPTY}></h3>
        <{/if}>
    </div>
<{/if}>
