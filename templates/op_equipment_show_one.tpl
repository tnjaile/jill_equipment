<h2 class="text-center"><{$OneEquipment.title}></h2>

<div class="alert alert-warning text-right">
      <i class="fa fa-folder-open"></i> <{$OneCate.cate_name}>
</div>

<div class="alert alert-info">
    <i class="fa fa-users"></i> <{$OneEquipment.auditor}>
</div>

<!--說明-->
<div class="row">
    <label class="col-sm-3 text-right">
        <{$smarty.const._MA_JILLEQUIPMENT_DIRECTIONS}>
    </label>
    <div class="col-sm-9">
        <{$OneEquipment.directions}>
    </div>
</div>
<!--數量-->
<div class="row">
    <label class="col-sm-3 text-right">
        <{$smarty.const._MA_JILLEQUIPMENT_TOTAL}>
    </label>
    <div class="col-sm-9">
        <{$OneEquipment.total}>
    </div>
</div>

<!--可預約群組-->
<div class="row">
    <label class="col-sm-3 text-right">
        <{$smarty.const._MA_JILLEQUIPMENT_BOOKING_GROUP}>
    </label>
    <div class="col-sm-9">
        <{$OneEquipment.booking_name}>
    </div>
</div>

<div class="text-right">
    <{if $smarty.session.jill_equipment_adm}>
        <a href="javascript:equipment_destroy_func(<{$OneEquipment.sn}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
        <a href="<{$action}>?op=equipment_form&sn=<{$OneEquipment.sn}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
        <a href="<{$action}>?op=equipment_form&cate_id=<{$OneCate.cate_id}>" class="btn btn-primary"><{$smarty.const._TAD_ADD}></a>
        <a href="<{$xoops_url}>/modules/jill_equipment/admin/equipmentTime.php?cate_id=<{$OneCate.cate_id}>" class="btn btn-info"><{$smarty.const._MA_JILLEQUIPMENT_TIMESET}></a>
    <{/if}>
    <a href="<{$action}>?sn=<{$OneEquipment.sn}>" class="btn btn-success"><{$smarty.const._MD_JILLEQUIPMENT_BACK}></a>
</div>
