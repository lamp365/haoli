<?php
if(empty($_GP['qpay_MCH_ID'])||empty($_GP['qpay_MCH_KEY']))
{
    message("请填写完整");
}



$pay_submit_data=array(
    'qpay_MCH_ID'          => $_GP['qpay_MCH_ID'],
    'qpay_MCH_KEY'         => $_GP['qpay_MCH_KEY']
);

    mysqld_update('payment',array('order' => $_GP['pay_order'],'configs'=> serialize($pay_submit_data)) , array('code' => 'qpay'));
	mysqld_update('payment', array('enabled' => '1') , array('code' => 'qpay'));
?>