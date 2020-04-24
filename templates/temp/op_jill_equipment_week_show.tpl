
<div class="alert alert-warning text-right">
       
</div>



<div class="text-right">
    <{if $smarty.session.jill_equipment_adm}>
        <a href="javascript:jill_equipment_week_destroy_func(<{$bsn_week_tsn}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
        <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_week_edit&bsn_week_tsn=<{$bsn_week_tsn}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
        <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_week_create" class="btn btn-primary"><{$smarty.const._TAD_ADD}></a>
    <{/if}>
    <a href="<{$xoops_url}>/modules/jill_equipment/" class="btn btn-success"><{$smarty.const._TAD_HOME}></a>
</div>
