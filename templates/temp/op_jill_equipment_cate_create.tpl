

<!--套用formValidator驗證機制-->
<form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" enctype="multipart/form-data">
    

    <!--分類名稱-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_CATE_NAME}>
        </label>
        <div class="col-sm-6">
            <input type="text" name="cate_name" id="cate_name" class="form-control validate[required]" value="<{$cate_name}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_CATE_NAME}>">
        </div>
    </div>

    <!--排序-->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLEQUIPMENT_CATE_SORT}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="cate_sort" id="cate_sort" class="form-control " value="<{$cate_sort}>" placeholder="<{$smarty.const._MA_JILLEQUIPMENT_CATE_SORT}>">
        </div>
    </div>

    <div class="text-center">
        
        <!--分類編號-->
        <input type='hidden' name="cate_id" value="<{$cate_id}>">

        <{$token_form}>

        <input type="hidden" name="op" value="<{$next_op}>">
        <input type="hidden" name="cate_id" value="<{$cate_id}>">
        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
    </div>
</form>
