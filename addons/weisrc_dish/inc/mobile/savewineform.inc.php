<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$storeid = intval($_GPC['storeid']);

if ($storeid == 0) {
    message('门店不存在！');
} else {
    $store = $this->getStoreById($storeid);
}

include $this->template($this->cur_tpl . '/savewine_form');