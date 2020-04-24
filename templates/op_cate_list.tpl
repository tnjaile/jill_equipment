<{if $AllCate}>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <!--分類名稱-->
                    <th>
                        <{$smarty.const._MD_JILLEQUIPMENT_IS_ENABLE}> <{$smarty.const._MA_JILLEQUIPMENT_CATE_NAME}>
                    </th>
                    <{if $smarty.session.jill_equipment_adm}>
                        <th><{$smarty.const._TAD_FUNCTION}></th>
                    <{/if}>
                </tr>
            </thead>
            <tbody id="jill_equipment_cate_sort">
                <{foreach from=$AllCate item=data}>
                    <tr id="tr_<{$data.cate_id}>">
                        <!--分類名稱-->
                        <td>
                            <{if $data.is_enable==1}>
                                <img src="<{$xoops_url}>/modules/jill_equipment/images/yes.gif" alt="<{$smarty.const._YES}>" title="<{$smarty.const._YES}>" />
                            <{else}>
                                <img src="<{$xoops_url}>/modules/jill_equipment/images/no.gif" alt="<{$smarty.const._NO}>" title="<{$smarty.const._NO}>" />
                            <{/if}>
                            <{$data.cate_name}>
                        </td>
                        <{if $smarty.session.jill_equipment_adm}>
                            <td nowrap>
                                <a href="javascript:cate_destroy_func(<{$data.cate_id}>);" class="btn btn-sm btn-danger" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash-o"></i></a>
                                <a href="<{$action}>?op=cate_form&cate_id=<{$data.cate_id}>" class="btn btn-sm btn-warning" title="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil"></i></a>
                                <a href="<{$xoops_url}>/modules/jill_equipment/admin/equipment.php?cate_id=<{$data.cate_id}>" class="btn btn-sm btn-primary"><{$smarty.const._MA_JILLEQUIPMENT_INFO}></a>
                            </td>
                        <{/if}>
                    </tr>
                <{/foreach}>
            </tbody>
        </table>
    </div>
    <{includeq file="$xoops_rootpath/modules/jill_equipment/templates/snippet_page.tpl"}>
    <{if $smarty.session.jill_equipment_adm}>
        <div class="text-right">
            <a href="<{$action}>?op=cate_form" class="btn btn-info">
            <i class="fa fa-plus"></i> <{$smarty.const._TAD_ADD}>
            </a>
        </div>
    <{/if}>
<{else}>
    <div class="jumbotron text-center">
        <{if $smarty.session.jill_equipment_adm}>
            <a href="<{$action}>?op=cate_form" class="btn btn-info">
            <i class="fa fa-plus"></i> <{$smarty.const._TAD_ADD}>
            </a>
        <{else}>
            <h3><{$smarty.const._TAD_EMPTY}></h3>
        <{/if}>
    </div>
<{/if}>
