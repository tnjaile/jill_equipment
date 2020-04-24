

<!--套用formValidator驗證機制-->
<form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" enctype="multipart/form-data">
    

    <!--設備編號-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_SN}>
        </label>
        <div class="col-sm-6">
            <select name="sn" class="form-control " size=1>
                <option value=""></option>
                <{foreach from=$sn_options item=opt}>
                    <option value="<{$opt.sn}>" <{if $sn==$opt.sn}>selected<{/if}>><{$opt.title}></option>
                <{/foreach}>
            </select>
        </div>
    </div>

    <!--時段標題-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_TITLE}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="title" id="title" class="form-control " value="<{$title}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_TITLE}>">
        </div>
    </div>

    <!--時段排序-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_TSORT}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="tsort" id="tsort" class="form-control " value="<{$tsort}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_TSORT}>">
        </div>
    </div>

    <!--開放星期-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_OPEN_WEEK}>
        </label>
        <div class="col-sm-10">
            
            <div class="form-check form-check-inline">
                <input type="checkbox" name="open_week[]" id="open_week_" class="form-check-input" value="" <{if ""|in_array:$open_week}>checked="checked"<{/if}>>
                <label class="form-check-label" for="open_week_"></label>
            </div>
        </div>
    </div>

    <div class="text-center">
        
        <!--時段編號-->
        <input type='hidden' name="tsn" value="<{$tsn}>">

        <{$token_form}>

        <input type="hidden" name="op" value="<{$next_op}>">
        <input type="hidden" name="tsn" value="<{$tsn}>">
        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
    </div>
</form>
