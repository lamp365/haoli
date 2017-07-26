<?php
/**
 * Created by PhpStorm.
 * User: 刘建凡
 * Date: 2017/6/22
 * Time: 16:28
 */
namespace home\controller;

class tenpay extends \home\controller\base
{
    /**
     * 支付宝支付（即时到帐）
     * @param string $ordersn 订单号
     */
    public function pay() {
        $pay_data = array(
            'out_trade_no'  => date('YmdHis').uniqid(), //订单号
            'subject'       => '456',  //标题
            'total_fee'     => 1, //订单金额，单位为元
        );
        $payobj = new \service\shopwap\tenpayService();
        $payobj->tenpay($pay_data);
    }

    /**
     * 服务器异步通知页面方法
     */
    function notifyUrl()
    {
        $pay = new \service\shopwap\alipayService();
        $result = $pay->notify_alipay();
        if($result){
            ajaxReturnData(1,'支付成功','success');
        }else{
            ajaxReturnData(0,'支付失败','fail');
        }
    }

    /**
     * 同步通知页面跳转处理方法
     */
    function returnUrl()
    {
        $pay = new \service\shopwap\alipayService();
        $result = $pay->return_alipay();
        if($result) {
            message('支付成功！',mobile_url('order',array('name'=>'home')),'success');
        } else {
            message($pay->getError());
        }
    }

}