<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17/7/15
 * Time: 下午3:54
 */
namespace home\controller;

class confirm extends \home\controller\base
{
    public function __construct()
    {
        parent::__construct();
        if(!checkIsLogin()){
            message('请您先登录!',refresh(),'error');
        }
    }

    public function index()
    {
        $_GP =  $this->request;
        if(empty($_GP['paytype'])){
            message('请选择支付类型',refresh(),'error');
        }
        $orderservice = new \service\shopwap\payorderService();
        //插入订单的信息
        $res_data     = $orderservice->insertOrder($_GP);
        if(!$res_data){
            message($orderservice->getError(),refresh(),'error');
        }

        $this->payorder($_GP['paytype'],$res_data);

    }

    public function topay()
    {
        $_GP    = $this->request;
        $openid = checkIsLogin();
        if(empty($_GP['orderid'])){
            message('参数有误!',refresh(),'error');
        }
        if(empty($_GP['paytype'])){
            message('请选择支付类型',refresh(),'error');
        }
        $order = mysqld_select("select * from ".table('shop_order')." where id={$_GP['orderid']}");
        if($openid != $order['openid']){
            message('对不起,订单不存在!',refresh(),'error');
        }

        $sql = 'select d.title from '.table('shop_order_goods')." as g left join ".table('shop_dish')." as d on g.goodsid=d.id where g.orderid={$order['id']}";
        $goods = mysqld_select($sql);

        $pay_title        = str_replace('&','',$goods['title']);  //去除带有 & 的字符
        $pay_title        = str_replace("'", '‘', $pay_title);
        $pay_title        = str_replace(" ", '', $pay_title);

        $res_data['pay_ordersn']     = $order['ordersn'];
        $res_data['pay_total_money'] = $order['price'];
        $res_data['pay_title']       = $pay_title;

        $this->payorder($_GP['paytype'],$res_data);
    }

    public function payorder($paytype,$res_data)
    {
        if($paytype == 'weixin'){
            $pay_data = array(
                'out_trade_no'  => $res_data['pay_ordersn'], //订单号
                'total_fee'     => $res_data['pay_total_money']*100, //订单金额，单位为分
                'body'          => $res_data['pay_title'],
            );
            $payobj    = new \service\shopwap\weixinpayService();
            $result    = $payobj->weixinpay($pay_data);
            if (!$result) {
                message($payobj->getError(),refresh(),'error');
            }else{
                $cfg = globaSetting();
                //如果是PC端那么返回的是一段 扫码地址  如果是小程序或者微信端返回一个数组参数
                include themePage('weixinpay');
            }
        }else if($paytype == 'ali'){
            $pay_data = array(
//            'notify_url'  => WEBSITE_ROOT.'notify/alipay_notify.php',      //服务器异步通知页面路径
                'notify_url'    => mobile_url('alipay',array('name'=>'home','op'=>'notifyurl')),        //服务器异步通知页面路径
//            'return_url'  => WEBSITE_ROOT.'notify/alipay_return_url.php', //页面跳转同步通知页面路径
                'return_url'    => mobile_url('alipay',array('name'=>'home','op'=>'returnurl')), //页面跳转同步通知页面路径
                'out_trade_no'  => $res_data['pay_ordersn'], //订单号
                'subject'       => $res_data['pay_ordersn'],  //标题
                'total_fee'     => $res_data['pay_total_money'], //订单金额，单位为元
                'body'          => $res_data['pay_title'],
                'show_url'      => WEBSITE_ROOT,  //商品展示地址 通过支付页面的表单进行传递
            );
            $payobj    = new \service\shopwap\alipayService();
            $result    = $payobj->alipay($pay_data);
            if (!$result) {
                message($payobj->getError(),refresh(),'error');
            }else{
                die($result);
            }
        }else if($paytype == 'ten'){
            $pay_data = array(
                'out_trade_no'  => $res_data['pay_ordersn'], //订单号
                'subject'       => $res_data['pay_title'],  //标题
                'total_fee'     => $res_data['pay_total_money'], //订单金额，单位为元
            );
            $payobj = new \service\shopwap\tenpayService();
            $payobj->tenpay($pay_data);
        }
    }

    public function check_order()
    {
        $_GP    = $this->request;
        if(empty($_GP['orderid'])){
            //找出最后一条
            $sql = "select * from ".table('shop_order')." order by id desc";
        }else{
            $sql = "select * from ".table('shop_order')." where id ={$_GP['orderid']}";
        }
        $order  = mysqld_select($sql);
        $status = intval($order['status']);
        ajaxReturnData(1,'',array('status'=>$status));
    }

}