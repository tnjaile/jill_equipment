<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>


<!--套用formValidator驗證機制-->
<form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" enctype="multipart/form-data">
    

    <!--預約理由-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MD_JILLEQUIPMENT_BOOKING_CONTENT}>
        </label>
        <div class="col-sm-6">
            <textarea name="booking_content" rows=8 id="booking_content" class="form-control " placeholder="<{$smarty.const._MD_JILLEQUIPMENT_BOOKING_CONTENT}>"><{$booking_content}></textarea>
        </div>
    </div>

    <!--使用地點-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MD_JILLEQUIPMENT_PLACE}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="place" id="place" class="form-control " value="<{$place}>" placeholder="<{$smarty.const._MD_JILLEQUIPMENT_PLACE}>">
        </div>
    </div>

    <!--開始日期 date-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MD_JILLEQUIPMENT_START}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="start" id="start" class="form-control " value="<{$start}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="<{$smarty.const._MD_JILLEQUIPMENT_START}>">
        </div>
    </div>

    <!--預定歸還日期 date-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MD_JILLEQUIPMENT_END}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="end" id="end" class="form-control " value="<{$end}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="<{$smarty.const._MD_JILLEQUIPMENT_END}>">
        </div>
    </div>

    <div class="text-center">
        
        <!--預約者-->
        <input type='hidden' name="buid" value="<{$buid}>">

        <{$token_form}>

        <input type="hidden" name="op" value="<{$next_op}>">
        <input type="hidden" name="bsn" value="<{$bsn}>">
        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
    </div>
</form>
