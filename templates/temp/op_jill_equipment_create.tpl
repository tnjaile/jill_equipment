<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>


<!--套用formValidator驗證機制-->
<form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" enctype="multipart/form-data">


    <!--分類編號-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_CATE_ID}>
        </label>
        <div class="col-sm-6">
            <select name="cate_id" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$cate_id_options item=opt}>
                    <option value="<{$opt.cate_id}>" <{if $cate_id==$opt.cate_id}>selected<{/if}>><{$opt.cate_name}></option>
                <{/foreach}>
            </select>
        </div>
    </div>

    <!--設備名稱-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_TITLE}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="title" id="title" class="form-control validate[required]" value="<{$title}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_TITLE}>">
        </div>
    </div>

    <!--設備說明-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_DESC}>
        </label>
        <div class="col-sm-6">
            <{$desc_editor}>
        </div>
    </div>

    <!--保管人-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_DEPOSITARY}>
        </label>
        <div class="col-sm-5">
            <input type="text" name="depositary" id="depositary" class="form-control " value="<{$depositary}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_DEPOSITARY}>">
        </div>
    </div>

    <!--購置日期 date-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_BUYING}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="buying" id="buying" class="form-control " value="<{$buying}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_BUYING}>">
        </div>
    </div>

    <!--財產編號-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_PROPERTY_NO}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="property_no" id="property_no" class="form-control " value="<{$property_no}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_PROPERTY_NO}>">
        </div>
    </div>

    <!--年限-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_LIFE_SPAN}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="life_span" id="life_span" class="form-control " value="<{$life_span}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_LIFE_SPAN}>">
        </div>
    </div>

    <!--數量-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_TOTAL}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="total" id="total" class="form-control " value="<{$total}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_TOTAL}>">
        </div>
    </div>

    <!--可借數量-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_AMOUNT}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="amount" id="amount" class="form-control " value="<{$amount}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_AMOUNT}>">
        </div>
    </div>

    <!--保管單位-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_PROPERTY_SECTION}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="property_section" id="property_section" class="form-control " value="<{$property_section}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_PROPERTY_SECTION}>">
        </div>
    </div>

    <!--目前所在位置-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_LOCATION}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="location" id="location" class="form-control " value="<{$location}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_LOCATION}>">
        </div>
    </div>

    <!--可審核人員-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_AUDITOR}>
        </label>
        <div class="col-sm-6">
            <textarea name="auditor" rows=8 id="auditor" class="form-control " placeholder="<{$smarty.const._MA_JILLEQUIPMENT_AUDITOR}>"><{$auditor}></textarea>
        </div>
    </div>

    <div class="text-center">

        <!--設備編號-->
        <input type='hidden' name="sn" value="<{$sn}>">

        <{$token_form}>

        <input type="hidden" name="op" value="<{$next_op}>">
        <input type="hidden" name="sn" value="<{$sn}>">
        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
    </div>
</form>
