<h2 class="text-center"><{$cate_name}></h2>

<div class="alert alert-warning text-right">
       
</div>



<div class="text-right">
    <{if $smarty.session.jill_equipment_adm}>
        <a href="javascript:jill_equipment_cate_destroy_func(<{$cate_id}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
        <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_cate_edit&cate_id=<{$cate_id}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
        <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_cate_create" class="btn btn-primary"><{$smarty.const._TAD_ADD}></a>
    <{/if}>
    <a href="<{$xoops_url}>/modules/jill_equipment/" class="btn btn-success"><{$smarty.const._TAD_HOME}></a>
</div>
