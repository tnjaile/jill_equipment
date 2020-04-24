<?php
//分類驗證類
class CateCheck extends Check
{
    // 新增時要做檢查(範例)
    public function addCheck(Model &$_model)
    {
        if (self::isNullString($_POST['cate_name'])) {
            $this->_message[] = '分類標題不得為空！';
            return false;
        }

        return true;
    }

}
