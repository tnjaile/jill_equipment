<{if $all_jill_equipment_date}>
    <{if $smarty.session.jill_equipment_adm}>
        
    <{/if}>

    <div id="jill_equipment_date_save_msg"></div>

    <table class="table table-striped table-hover">
        <thead>
            <tr class="info">
                
                <!--預約日期-->
                <th>
                    <{$smarty.const._MD_JILLEQUIPMENT_BDATE}>
                </th>
                <!--時段編號-->
                <th>
                    <{$smarty.const._MD_JILLEQUIPMENT_TSN}>
                </th>
                <!--狀態-->
                <th>
                    <{$smarty.const._MD_JILLEQUIPMENT_STATUS}>
                </th>
                <!--審核者-->
                <th>
                    <{$smarty.const._MD_JILLEQUIPMENT_APPROVER}>
                </th>
                <!--借出時間-->
                <th>
                    <{$smarty.const._MD_JILLEQUIPMENT_LOAN_DATE}>
                </th>
                <!--實際歸還時間-->
                <th>
                    <{$smarty.const._MD_JILLEQUIPMENT_RETURN_DATE}>
                </th>
                <{if $smarty.session.jill_equipment_adm}>
                    <th><{$smarty.const._TAD_FUNCTION}></th>
                <{/if}>
            </tr>
        </thead>

        <tbody id="jill_equipment_date_sort">
            <{foreach from=$all_jill_equipment_date item=data}>
                <tr id="tr_<{$data.bsn_bdate_tsn}>">
                    
                        <!--預約日期-->
                        <td>
                            <{$data.bdate}>
                        </td>

                        <!--時段編號-->
                        <td>
                            <a href="<{$xoops_url}>/modules/jill_equipment?tsn=<{$data.tsn}>">
                <{$data.tsn_title}>
                </a>
                        </td>

                        <!--狀態-->
                        <td>
                            <{$data.status}>
                        </td>

                        <!--審核者-->
                        <td>
                            <a href="<{$xoops_user}>/user.php?uid=<{$data.approver}>"><{$data.approver_name}></a>
                        </td>

                        <!--借出時間-->
                        <td>
                            <{$data.loan_date}>
                        </td>

                        <!--實際歸還時間-->
                        <td>
                            <{$data.return_date}>
                        </td>

                    <{if $smarty.session.jill_equipment_adm}>
                        <td nowrap>
                            <a href="javascript:jill_equipment_date_destroy_func(<{$data.bsn_bdate_tsn}>);" class="btn btn-sm btn-danger" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash-o"></i></a>
                            <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_date_edit&bsn_bdate_tsn=<{$data.bsn_bdate_tsn}>" class="btn btn-sm btn-warning" title="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil"></i></a>
                            
                        </td>
                    <{/if}>
                </tr>
            <{/foreach}>
        </tbody>
    </table>


    <{if $smarty.session.jill_equipment_adm}>
        <div class="text-right">
            <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_date_create&tsn=<{$tsn}>" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        </div>
    <{/if}>

    <{$bar}>
<{else}>
    <div class="jumbotron text-center">
        <{if $smarty.session.jill_equipment_adm}>
            <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_date_create&tsn=<{$tsn}>" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        <{else}>
            <h3><{$smarty.const._TAD_EMPTY}></h3>
        <{/if}>
    </div>
<{/if}>
