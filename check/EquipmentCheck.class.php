<?php
//設備驗證類
class EquipmentCheck extends Check
{
    // 新增時要做檢查(範例)
    public function addCheck(Model &$_model)
    {
        if (self::isNullString($_POST['title'])) {
            $this->_message[] = '標題不得為空！';
            return false;
        }

        if (self::isNullString($_POST['total'])) {
            $this->_message[] = '數量不得為空！';
            return false;
        }
        if (self::checkStrLength($_POST['total'], 1, 'min')) {
            $this->_message[] = '數量不得小於1！';
            return false;
        }
        return true;
    }

}
