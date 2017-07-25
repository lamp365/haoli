<?php
if(empty($_GP['tenpay_partner'])||empty($_GP['tenpay_key']))
{
    message("请填写完整");
}



$pay_submit_data=array(
    'tenpay_partner'     => $_GP['tenpay_partner'],
    'tenpay_key'         => $_GP['tenpay_key']
);

    mysqld_update('payment',array('order' => $_GP['pay_order'],'configs'=> serialize($pay_submit_data)) , array('code' => 'tenpay'));
	mysqld_update('payment', array('enabled' => '1') , array('code' => 'tenpay'));
?>