<{if $all_jill_equipment_time}>
    <{if $smarty.session.jill_equipment_adm}>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#jill_equipment_time_sort").sortable({ opacity: 0.6, cursor: "move", update: function() {
                    var order = $(this).sortable("serialize");
                    $.post("<{$xoops_url}>/modules/jill_equipment/admin/jill_equipment_time_save_sort.php", order + "&op=update_jill_equipment_time_sort", function(msg){
                        $("#jill_equipment_time_save_msg").html(msg);
                    });
                }
                });
            });
        </script>
    <{/if}>

    <div id="jill_equipment_time_save_msg"></div>

    <table class="table table-striped table-hover">
        <thead>
            <tr class="info">
                
                <!--設備編號-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_SN}>
                </th>
                <!--時段標題-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_TITLE}>
                </th>
                <!--開放星期-->
                <th>
                    <{$smarty.const._MA_JILLEQUIPMENT_OPEN_WEEK}>
                </th>
                <{if $smarty.session.jill_equipment_adm}>
                    <th><{$smarty.const._TAD_FUNCTION}></th>
                <{/if}>
            </tr>
        </thead>

        <tbody id="jill_equipment_time_sort">
            <{foreach from=$all_jill_equipment_time item=data}>
                <tr id="tr_<{$data.tsn}>">
                    
                        <!--設備編號-->
                        <td>
                            <a href="<{$xoops_url}>/modules/jill_equipment?sn=<{$data.sn}>">
                <{$data.sn_title}>
                </a>
                        </td>

                        <!--時段標題-->
                        <td>
                            <a href="<{$xoops_url}>/modules/jill_equipment?tsn=<{$data.tsn}>">
                <{$data.title}>
                </a>
                        </td>

                        <!--開放星期-->
                        <td>
                            <{$data.open_week}>
                        </td>

                    <{if $smarty.session.jill_equipment_adm}>
                        <td nowrap>
                            <a href="javascript:jill_equipment_time_destroy_func(<{$data.tsn}>);" class="btn btn-sm btn-danger" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash-o"></i></a>
                            <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_time_edit&tsn=<{$data.tsn}>" class="btn btn-sm btn-warning" title="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil"></i></a>
                            <i class="fa fa-sort" aria-hidden="true" title="<{$smarty.const._TAD_SORTABLE}>"></i>
                        </td>
                    <{/if}>
                </tr>
            <{/foreach}>
        </tbody>
    </table>


    <{if $smarty.session.jill_equipment_adm}>
        <div class="text-right">
            <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_time_create&sn=<{$sn}>" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        </div>
    <{/if}>

    <{$bar}>
<{else}>
    <div class="jumbotron text-center">
        <{if $smarty.session.jill_equipment_adm}>
            <a href="<{$xoops_url}>/modules/jill_equipment/admin/main.php?op=jill_equipment_time_create&sn=<{$sn}>" class="btn btn-info">
            <i class="fa fa-plus"></i><{$smarty.const._TAD_ADD}>
            </a>
        <{else}>
            <h3><{$smarty.const._TAD_EMPTY}></h3>
        <{/if}>
    </div>
<{/if}>
