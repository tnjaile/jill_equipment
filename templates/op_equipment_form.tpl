<h2 class="text-center"><a href="<{$action}>?cate_id=<{$OneCate.cate_id}>"><i class="fa fa-reply" aria-hidden="true"></i>  <{$OneCate.cate_name}><{$smarty.const._MA_JILLEQUIPMENT_INFO}></a></h2>
<!--套用formValidator驗證機制-->
<form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm">
    <!--設備名稱-->
    <div class="form-group row">
      <label class="col-sm-2 col-form-label text-md-right">
          <{$smarty.const._MA_JILLEQUIPMENT_TITLE}>
      </label>
      <div class="col-sm-10">
          <input type="text" name="title" id="title" class="form-control validate[required]" value="<{$OneEquipment.title}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_TITLE}>">
      </div>
    </div>

    <!--設備說明-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_DIRECTIONS}>
        </label>
        <div class="col-sm-10">
          <{$directions_editor}>
        </div>
    </div>

    <!--數量-->
    <div class="form-group row">
      <label class="col-sm-2 col-form-label text-md-right">
          <{$smarty.const._MA_JILLEQUIPMENT_TOTAL}>
      </label>
      <div class="col-sm-10">
          <input type="text" name="total" id="total" class="form-control validate[required, min[1], custom[integer]] " value="<{$OneEquipment.total}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_TOTAL}>">
      </div>
    </div>
    <!--可審核人員-->
    <div class="form-group row">
      <label class="col-sm-2 col-form-label text-md-right">
        <{$smarty.const._MA_JILLEQUIPMENT_AUDITOR}>
      </label>
      <div class="col-sm-10">
        <textarea name="auditor" rows=8 id="auditor" class="form-control validate[required]" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_AUDITOR_DESC}>"><{$OneEquipment.auditor}></textarea>
      </div>
    </div>

    <!--可預約群組-->
    <div class="form-group row">
      <label class="col-sm-2 col-form-label text-md-right">
          <{$smarty.const._MA_JILLEQUIPMENT_BOOKING_GROUP}>
      </label>
      <div class="col-sm-10">
          <select name="booking_group[]" class="form-control" size='10' multiple>
              <{foreach from=$AllGroup key=b item=g}>
                  <option value=<{$b}> <{if $b|in_array:$OneEquipment.booking_group}>selected<{/if}> ><{$g}></option>
              <{/foreach}>
          </select>
      </div>
    </div>
    <div class="text-center">
      <{$token_form}>
      <input type="hidden" name="cate_id" value="<{$OneCate.cate_id}>">
      <input type="hidden" name="sn" value="<{$OneEquipment.sn}>">
        <input type="hidden" name="next_op" value="<{$next_op}>">
        <input type="hidden" name="op" value="<{$now_op}>">
        <input type="submit" name="send" value="<{$smarty.const._TAD_SAVE}>" class="btn btn-primary" />
    </div>
</form>
