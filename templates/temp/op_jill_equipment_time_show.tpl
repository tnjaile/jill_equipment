<h2 class="text-center"><{$title}></h2>

<div class="alert alert-warning text-right">
      <i class="fa fa-folder-open"></i> <{$sn_title}> 
</div>


<!--開放星期-->
<div class="row">
    <label class="col-sm-3 text-right">
        <{$smarty.const._MA_JILLEQUIPMENT_OPEN_WEEK}>checkbox
    </label>
    <div class="col-sm-9">
        <{$open_week}>
    </div>
</div>


<div class="text-right">
    <{if $smarty.session.jill_equipment_adm}>
        <a href="javascript:jill_equipment_time_destroy_func(<{$tsn}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
        <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_time_edit&tsn=<{$tsn}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
        <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_time_create" class="btn btn-primary"><{$smarty.const._TAD_ADD}></a>
    <{/if}>
    <a href="<{$xoops_url}>/modules/jill_equipment/" class="btn btn-success"><{$smarty.const._TAD_HOME}></a>
</div>
