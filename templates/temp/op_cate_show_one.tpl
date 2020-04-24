<h2 class="text-center"><{$OneCate.cate_name}></h2>

<div class="text-right">
  <a href="javascript:cate_destroy_func(<{$OneCate.cate_id}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
  <a href="<{$action}>?op=cate_form&cate_id=<{$OneCate.cate_id}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
  <a href="<{$action}>?op=cate_form" class="btn btn-primary"><{$smarty.const._TAD_ADD}></a>
  <a href="<{$action}>" class="btn btn-success"><{$smarty.const._MD_JILLEQUIPMENT_BACK}></a>
</div>