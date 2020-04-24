<{if $all_jill_equipment_week}>
    <{if $smarty.session.jill_equipment_adm}>
        
    <{/if}>

    <div id="jill_equipment_week_save_msg"></div>

    <table class="table table-striped table-hover">
        <thead>
            <tr class="info">
                
                <{if $smarty.session.jill_equipment_adm}>
                    <th><{$smarty.const._TAD_FUNCTION}></th>
                <{/if}>
            </tr>
        </thead>

        <tbody id="jill_equipment_week_sort">
            <{foreach from=$all_jill_equipment_week item=data}>
                <tr id="tr_<{$data.bsn_week_tsn}>">
                    
                    <{if $smarty.session.jill_equipment_adm}>
                        <td nowrap>
                            <a href="javascript:jill_equipment_week_destroy_func(<{$data.bsn_week_tsn}>);" class="btn btn-sm btn-danger" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash-o"></i></a>
                            <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_week_edit&bsn_week_tsn=<{$data.bsn_week_tsn}>" class="btn btn-sm btn-warning" title="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil"></i></a>
                            
                        </td>
                    <{/if}>
                </tr>
            <{/foreach}>
        </tbody>
    </table>


    <{if $smarty.session.jill_equipment_adm}>
        <div class="text-right">
            <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_week_create" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        </div>
    <{/if}>

    <{$bar}>
<{else}>
    <div class="jumbotron text-center">
        <{if $smarty.session.jill_equipment_adm}>
            <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_week_create" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        <{else}>
            <h3><{$smarty.const._TAD_EMPTY}></h3>
        <{/if}>
    </div>
<{/if}>
