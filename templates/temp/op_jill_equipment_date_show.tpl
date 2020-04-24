
<div class="alert alert-warning text-right">
    <i class="fa fa-user"></i> <{$approver_name}> <i class="fa fa-calendar"></i> <{$return_date}> <i class="fa fa-folder-open"></i> <{$tsn_title}> 
</div>


<!--預約日期-->
<div class="row">
    <label class="col-sm-3 text-right">
        <{$smarty.const._MD_JILLEQUIPMENT_BDATE}>date
    </label>
    <div class="col-sm-9">
        <{$bdate}>
    </div>
</div>


<div class="text-right">
    <{if $smarty.session.jill_equipment_adm}>
        <a href="javascript:jill_equipment_date_destroy_func(<{$bsn_bdate_tsn}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
        <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_date_edit&bsn_bdate_tsn=<{$bsn_bdate_tsn}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
        <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_date_create" class="btn btn-primary"><{$smarty.const._TAD_ADD}></a>
    <{/if}>
    <a href="<{$xoops_url}>/modules/jill_equipment/" class="btn btn-success"><{$smarty.const._TAD_HOME}></a>
</div>
