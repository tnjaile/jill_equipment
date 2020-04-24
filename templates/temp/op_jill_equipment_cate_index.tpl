<{if $all_jill_equipment_cate}>
    <{if $smarty.session.jill_equipment_adm}>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#jill_equipment_cate_sort").sortable({ opacity: 0.6, cursor: "move", update: function() {
                    var order = $(this).sortable("serialize");
                    $.post("<{$xoops_url}>/modules/jill_equipment/admin/jill_equipment_cate_save_sort.php", order + "&op=update_jill_equipment_cate_sort", function(msg){
                        $("#jill_equipment_cate_save_msg").html(msg);
                    });
                }
                });
            });
        </script>
    <{/if}>

    <div id="jill_equipment_cate_save_msg"></div>

    <table class="table table-striped table-hover">
        <thead>
            <tr class="info">
                
                <!--分類名稱-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_CATE_NAME}>
                </th>
                <{if $smarty.session.jill_equipment_adm}>
                    <th><{$smarty.const._TAD_FUNCTION}></th>
                <{/if}>
            </tr>
        </thead>

        <tbody id="jill_equipment_cate_sort">
            <{foreach from=$all_jill_equipment_cate item=data}>
                <tr id="tr_<{$data.cate_id}>">
                    
                        <!--分類名稱-->
                        <td>
                            <a href="<{$xoops_url}>/modules/jill_equipment?cate_id=<{$data.cate_id}>">
                <{$data.cate_name}>
                </a>
                        </td>

                    <{if $smarty.session.jill_equipment_adm}>
                        <td nowrap>
                            <a href="javascript:jill_equipment_cate_destroy_func(<{$data.cate_id}>);" class="btn btn-sm btn-danger" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash-o"></i></a>
                            <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_cate_edit&cate_id=<{$data.cate_id}>" class="btn btn-sm btn-warning" title="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil"></i></a>
                            <i class="fa fa-sort" aria-hidden="true" title="<{$smarty.const._TAD_SORTABLE}>"></i>
                        </td>
                    <{/if}>
                </tr>
            <{/foreach}>
        </tbody>
    </table>


    <{if $smarty.session.jill_equipment_adm}>
        <div class="text-right">
            <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_cate_create" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        </div>
    <{/if}>

    <{$bar}>
<{else}>
    <div class="jumbotron text-center">
        <{if $smarty.session.jill_equipment_adm}>
            <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_cate_create" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        <{else}>
            <h3><{$smarty.const._TAD_EMPTY}></h3>
        <{/if}>
    </div>
<{/if}>
