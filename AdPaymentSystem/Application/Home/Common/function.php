<?php
//获取所有的期初金额
function get_defaultmoney()
{
    $defaultmoney_array = M('defaultmoney')->where(array('id' => 1))->getField('id,yearmonth,customname,defaultmoney', true);
    
    return $defaultmoney_array;

}

