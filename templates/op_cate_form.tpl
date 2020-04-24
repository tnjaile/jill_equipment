<!--套用formValidator驗證機制-->
<form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" >
    <!--分類名稱-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_CATE_NAME}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="cate_name" id="cate_name" class="form-control validate[required]" value="<{$OneCate.cate_name}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_CATE_NAME}>">
        </div>
    </div>

    <!--是否啟用-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MD_JILLEQUIPMENT_IS_ENABLE}>
        </label>
        <div class="col-sm-10">
            <div class="form-check form-check-inline">
                <input type="radio" name="is_enable" id="is_enable_1" class="form-check-input" value="1" <{if $OneCate.is_enable == "1" || $OneCate.is_enable == ""}>checked="checked"<{/if}>>
                <label class="form-check-label" for="is_enable_1"><{$smarty.const._YES}></label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="is_enable" id="is_enable_0" class="form-check-input" value="0" <{if $OneCate.is_enable == "0"}>checked="checked"<{/if}>>
                <label class="form-check-label" for="is_enable_0"><{$smarty.const._NO}></label>
            </div>
        </div>
    </div>

    <div class="text-center">
        <!--分類編號-->
        <input type='hidden' name="cate_id" value="<{$OneCate.cate_id}>">
        <{$token_form}>
        <input type="hidden" name="next_op" value="<{$next_op}>">
        <input type="hidden" name="op" value="<{$now_op}>">
        <input type="submit" name="send" value="<{$smarty.const._TAD_SAVE}>" class="btn btn-primary" />
    </div>
</form>