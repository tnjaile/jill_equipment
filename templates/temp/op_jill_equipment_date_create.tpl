<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>


<!--套用formValidator驗證機制-->
<form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" enctype="multipart/form-data">
    

    <!--預約日期 date-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MD_JILLEQUIPMENT_BDATE}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="bdate" id="bdate" class="form-control " value="<{$bdate}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="<{$smarty.const._MD_JILLEQUIPMENT_BDATE}>">
        </div>
    </div>

    <!--時段編號-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MD_JILLEQUIPMENT_TSN}>
        </label>
        <div class="col-sm-6">
            <select name="tsn" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$tsn_options item=opt}>
                    <option value="<{$opt.tsn}>" <{if $tsn==$opt.tsn}>selected<{/if}>><{$opt.title}></option>
                <{/foreach}>
            </select>
        </div>
    </div>

    <!--狀態-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MD_JILLEQUIPMENT_STATUS}>
        </label>
        <div class="col-sm-10">
            
            <div class="form-check form-check-inline">
                <input type="radio" name="status" id="status_" class="form-check-input" value="" <{if $status == ""}>checked="checked"<{/if}>>
                <label class="form-check-label" for="status_"></label>
            </div>
        </div>
    </div>

    <div class="text-center">
        
        <!--審核者-->
        <input type='hidden' name="approver" value="<{$approver}>">

        <{$token_form}>

        <input type="hidden" name="op" value="<{$next_op}>">
        <input type="hidden" name="bsn_bdate_tsn" value="<{$bsn_bdate_tsn}>">
        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
    </div>
</form>
