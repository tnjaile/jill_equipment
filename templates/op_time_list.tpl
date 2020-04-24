<{$jquery}>
<script type="text/javascript" src="<{$xoops_url}>/modules/jill_equipment/js/equipmentTime.js"></script>

<h2><a href="<{$xoops_url}>/modules/jill_equipment/admin/equipment.php?cate_id=<{$OneEquipment.cate_id}>"><i class="fa fa-reply" aria-hidden="true"></i>  <{$OneEquipment.title}><{$smarty.const._MA_JILLEQUIPMENT_TIMESET}></a></h2>

  <{if $OneEquipment.directions}>
    <!--設備說明-->
    <div class="row">
        <div class="card card-body bg-light m-1">
          <{$OneEquipment.directions}>
        </div>
    </div>
  <{/if}>

  <div id="time_sort_save_msg"></div>
  <div class="row">
    <div class="col-sm-7">
      <form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" role="form">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th rowspan="2" style="text-align: center; vertical-align: middle;">
                <!--時段標題-->
                <{$smarty.const._MA_JILLEQUIPMENT_TIME_TITLE}>
              </th>
              <th colspan="7" style="text-align: center;">
                <!--開放星期-->
                <{$smarty.const._MA_JILLEQUIPMENT_WEEK}>
              </th>
              <th rowspan="2" style="text-align: center; vertical-align: middle;">
                <{$smarty.const._TAD_FUNCTION}>
              </th>
            </tr>
            <tr>
              <th style="background-color: #4E525B;">
                <!--星期一-->
                <{$smarty.const._MA_JILLEQUIPMENT_W1}>
              </th>
              <th style="background-color: #4E525B;">
                <!--星期二-->
                <{$smarty.const._MA_JILLEQUIPMENT_W2}>
              </th>
              <th style="background-color: #4E525B;">
                <!--星期三-->
                <{$smarty.const._MA_JILLEQUIPMENT_W3}>
              </th>
              <th style="background-color: #4E525B;">
                <!--星期四-->
                <{$smarty.const._MA_JILLEQUIPMENT_W4}>
              </th>
              <th style="background-color: #4E525B;">
                <!--星期五-->
                <{$smarty.const._MA_JILLEQUIPMENT_W5}>
              </th>
              <th style="background-color: #4E525B;">
                <!--星期六-->
                <{$smarty.const._MA_JILLEQUIPMENT_W6}>
              </th>
              <th style="background-color: #4E525B;">
                <!--星期日-->
                <{$smarty.const._MA_JILLEQUIPMENT_W0}>
              </th>
            </tr>
          </thead>

          <tbody id="time_sort">
            <{if $AllTime}>
              <{foreach from=$AllTime item=data}>
                <tr id='tr_<{$data.tsn}>'>
                  <td style="text-align: center;">
                    <!--時段標題-->
                    <div  class="jq_title" id="title_<{$data.tsn}>"><{$data.title}></div>
                  </td>
                  <td style="text-align: center;">
                    <{if "1"|in_array:$data.open_week_arr}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/yes.gif" alt="<{$smarty.const._YES}>" title="<{$smarty.const._YES}>" class="open_week"  id='<{$data.tsn}>_1' onClick="change_enable(<{$data.tsn}>,1);" style='cursor: pointer;'/>
                    <{else}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/no.gif" alt="<{$smarty.const._NO}>" title="<{$smarty.const._NO}>"   class="open_week"  id='<{$data.tsn}>_1' onClick="change_enable(<{$data.tsn}>,1);" style='cursor: pointer;'/>
                    <{/if}>
                  </td>
                  <td style="text-align: center;">
                    <{if "2"|in_array:$data.open_week_arr}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/yes.gif" alt="<{$smarty.const._YES}>" title="<{$smarty.const._YES}>"   class="open_week"  id='<{$data.tsn}>_2' onClick="change_enable(<{$data.tsn}>,2);" style='cursor: pointer;'/>
                    <{else}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/no.gif" alt="<{$smarty.const._NO}>" title="<{$smarty.const._NO}>"   class="open_week"  id='<{$data.tsn}>_2' onClick="change_enable(<{$data.tsn}>,2);" style='cursor: pointer;'/>
                    <{/if}>
                  </td>
                  <td style="text-align: center;">
                    <{if "3"|in_array:$data.open_week_arr}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/yes.gif" alt="<{$smarty.const._YES}>" title="<{$smarty.const._YES}>"   class="open_week"  id='<{$data.tsn}>_3' onClick="change_enable(<{$data.tsn}>,3);" style='cursor: pointer;'/>
                    <{else}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/no.gif" alt="<{$smarty.const._NO}>" title="<{$smarty.const._NO}>"   class="open_week"  id='<{$data.tsn}>_3' onClick="change_enable(<{$data.tsn}>,3);" style='cursor: pointer;'/>
                    <{/if}>
                  </td>
                  <td style="text-align: center;">
                    <{if "4"|in_array:$data.open_week_arr}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/yes.gif" alt="<{$smarty.const._YES}>" title="<{$smarty.const._YES}>"   class="open_week"  id='<{$data.tsn}>_4' onClick="change_enable(<{$data.tsn}>,4);" style='cursor: pointer;'/>
                    <{else}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/no.gif" alt="<{$smarty.const._NO}>" title="<{$smarty.const._NO}>"   class="open_week"  id='<{$data.tsn}>_4' onClick="change_enable(<{$data.tsn}>,4);" style='cursor: pointer;'/>
                    <{/if}>
                  </td>
                  <td style="text-align: center;">
                    <{if "5"|in_array:$data.open_week_arr}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/yes.gif" alt="<{$smarty.const._YES}>" title="<{$smarty.const._YES}>"   class="open_week"  id='<{$data.tsn}>_5' onClick="change_enable(<{$data.tsn}>,5);" style='cursor: pointer;'/>
                    <{else}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/no.gif" alt="<{$smarty.const._NO}>" title="<{$smarty.const._NO}>"   class="open_week"  id='<{$data.tsn}>_5' onClick="change_enable(<{$data.tsn}>,5);" style='cursor: pointer;'/>
                    <{/if}>
                  </td>
                  <td style="text-align: center;">
                    <{if "6"|in_array:$data.open_week_arr}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/yes.gif" alt="<{$smarty.const._YES}>" title="<{$smarty.const._YES}>"   class="open_week"  id='<{$data.tsn}>_6' onClick="change_enable(<{$data.tsn}>,6);" style='cursor: pointer;'/>
                    <{else}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/no.gif" alt="<{$smarty.const._NO}>" title="<{$smarty.const._NO}>"  class="open_week"  id='<{$data.tsn}>_6' onClick="change_enable(<{$data.tsn}>,6);" style='cursor: pointer;'/>
                    <{/if}>
                  </td>
                  <td style="text-align: center;">
                    <{if "0"|in_array:$data.open_week_arr}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/yes.gif" alt="<{$smarty.const._YES}>" title="<{$smarty.const._YES}>" class="open_week"  id='<{$data.tsn}>_0' onClick="change_enable(<{$data.tsn}>,0);" style='cursor: pointer;'/>
                    <{else}>
                      <img src="<{$xoops_url}>/modules/jill_equipment/images/no.gif" alt="<{$smarty.const._NO}>" title="<{$smarty.const._NO}>"  class="open_week"  id='<{$data.tsn}>_0' onClick="change_enable(<{$data.tsn}>,0);" style='cursor: pointer;'/>
                    <{/if}>
                  </td>
                  <td style="text-align: center;">
                    <i class="fa fa-sort text-primary" aria-hidden="true" title="<{$smarty.const._TAD_SORTABLE}>"></i>
                    <{if $data.booking_times!=""}>
                      <{$data.booking_times}>
                    <{else}>
                      <a href="javascript:time_destroy_func(<{$data.tsn}>);" class="btn btn-sm btn-danger ml-2"><{$smarty.const._TAD_DEL}></a>
                    <{/if}>
                  </td>
                </tr>
              <{/foreach}>
            <{/if}>
          </tbody>
          <tr>
            <td>
              <input type="text" name="title" id="title" class="form-control validate[required] " value="<{$title}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_TIME_TITLE}>" data-prompt-position="inline">
            </td>
            <td style="text-align: center;">
              <input type="checkbox" name="open_week_arr[]" value="1" checked="checked">
            </td>
            <td style="text-align: center;">
              <input type="checkbox" name="open_week_arr[]" value="2" checked="checked">
            </td>
            <td style="text-align: center;">
              <input type="checkbox" name="open_week_arr[]" value="3" checked="checked">
            </td>
            <td style="text-align: center;">
              <input type="checkbox" name="open_week_arr[]" value="4" checked="checked">
            </td>
            <td style="text-align: center;">
              <input type="checkbox" name="open_week_arr[]" value="5" checked="checked">
            </td>
            <td style="text-align: center;">
              <input type="checkbox" name="open_week_arr[]" value="6">
            </td>
            <td style="text-align: center;">
              <input type="checkbox" name="open_week_arr[]" value="0">
            </td>
            <td>
              <input type="hidden" name="sn" value="<{$OneEquipment.sn}>">
              <input type="hidden" name="op" value="time_form">
              <input type="submit" name="send" value="<{$smarty.const._MA_JILLEQUIPMENT_ADD_TIME}>" class="btn  btn-secondary btn-outline-primary" />
            </td>
          </tr>
        </table>
      </form>
    </div>
    <div class="col-sm-5">
      <{if !$AllTime}>
        <div class="list-group">
          <a href="#" class="list-group-item active">
            <{$smarty.const._MA_JILLEQUIPMENT_IMPORT}>
          </a>
          <a href="equipmentTime.php?op=time_import&sn=<{$OneEquipment.sn}>&type=18" class="list-group-item"><{$smarty.const._MA_JILLEQUIPMENT_IMPORT_18}></a>
          <a href="equipmentTime.php?op=time_import&sn=<{$OneEquipment.sn}>&type=apm" class="list-group-item"><{$smarty.const._MA_JILLEQUIPMENT_IMPORT_APM}></a>
          <{foreach from=$EquipmentInfo key=sn item=eq}>
            <a href="equipmentTime.php?op=time_import&sn=<{$OneEquipment.sn}>&type=copy&source=<{$sn}>" class="list-group-item"><{$eq}></a>
          <{/foreach}>
        </div>
      <{/if}>
    </div>
  </div>