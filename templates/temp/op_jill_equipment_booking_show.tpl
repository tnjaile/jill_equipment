
<div class="alert alert-warning text-right">
    <i class="fa fa-user"></i> <{$buid_name}> <i class="fa fa-calendar"></i> <{$booking_time}>  
</div>

<div class="alert alert-info">
    <{$booking_content}>
</div>

<!--使用地點-->
<div class="row">
    <label class="col-sm-3 text-right">
        <{$smarty.const._MD_JILLEQUIPMENT_PLACE}>text
    </label>
    <div class="col-sm-9">
        <{$place}>
    </div>
</div>

<!--開始日期-->
<div class="row">
    <label class="col-sm-3 text-right">
        <{$smarty.const._MD_JILLEQUIPMENT_START}>date
    </label>
    <div class="col-sm-9">
        <{$start}>
    </div>
</div>

<!--預定歸還日期-->
<div class="row">
    <label class="col-sm-3 text-right">
        <{$smarty.const._MD_JILLEQUIPMENT_END}>date
    </label>
    <div class="col-sm-9">
        <{$end}>
    </div>
</div>


<div class="text-right">
    <{if $smarty.session.jill_equipment_adm}>
        <a href="javascript:jill_equipment_booking_destroy_func(<{$bsn}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
        <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_booking_edit&bsn=<{$bsn}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
        <a href="<{$xoops_url}>/modules/jill_equipment/index.php?op=jill_equipment_booking_create" class="btn btn-primary"><{$smarty.const._TAD_ADD}></a>
    <{/if}>
    <a href="<{$xoops_url}>/modules/jill_equipment/" class="btn btn-success"><{$smarty.const._TAD_HOME}></a>
</div>
