<?php

namespace service\shopwap;
use kevin365\tenpay;

class tenpayService extends \service\publicService
{
    public $tenpay_config = array(
        'partner'    => '**********',          //这里是你在成功申请财付通接口后获取到的商户号；
        'key'        => '*******************', //这里是你在成功申请财付通接口后获取到的密钥
        'return_url' => '',
        'notify_url' => '',
    );

    /**
     * 构造函数
     * @param type $data
     */
    public function __construct() {
        parent::__construct();
        $payment = mysqld_select("SELECT * FROM " . table('payment') . " WHERE  enabled=1 and code='tenpay' limit 1");
        $configs = unserialize($payment['configs']);

        $this->tenpay_config['partner']    = $configs['tenpay_partner'];
        $this->tenpay_config['key']        = $configs['tenpay_key'];
        $this->tenpay_config['return_url'] = mobile_url('tenpay',array('op'=>'returnUrl'));
        $this->tenpay_config['notify_url'] = mobile_url('tenpay',array('op'=>'notifyUrl'));
    }

    /**
     * 支付宝支付
     * @param type [] 接口参数
     * @return type []
     */
    public function tenpay($data = array())
    {
        if(empty($data['subject'])){
            $this->error = '标题不能为空！';
            return false;
        }
        if(empty($data['out_trade_no']) || empty($data['total_fee'])){
            $this->error = '订单编号和金额不能为空！';
            return false;
        }
        if(empty($this->tenpay_config['notify_url']) || empty($this->tenpay_config['return_url'])){
            $this->error = '异步和通知地址不能为空！';
            return false;
        }
        $reqHandler = new \kevin365\tenpay\src\RequestHandler();

        /* 商户号，上线时务必将测试商户号替换为正式商户号 */
        $partner =  $this->tenpay_config['partner'];
        /* 密钥 */
        $key =  $this->tenpay_config['key'];
//        $data['subject'] = iconv('UTF-8','GB2312//IGNORE',$data['subject']);

        $reqHandler->init();
        $reqHandler->setKey($key);
        $reqHandler->setGateUrl("https://gw.tenpay.com/gateway/pay.htm");
        //----------------------------------------
        //设置支付参数
        //----------------------------------------
        $reqHandler->setParameter("partner", $partner);
        $reqHandler->setParameter("out_trade_no", $data['out_trade_no']);
        $reqHandler->setParameter("total_fee", $data['total_fee']);  //总金额
        $reqHandler->setParameter("return_url",  $this->tenpay_config['return_url']);
        $reqHandler->setParameter("notify_url", $this->tenpay_config['notify_url']);
        $reqHandler->setParameter("body", $data['subject']);
        $reqHandler->setParameter("bank_type", "DEFAULT");  	  //银行类型，默认为财付通

        //用户ip
        $reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);//客户端IP
        $reqHandler->setParameter("fee_type", "1");               //币种
        $reqHandler->setParameter("subject",$data['subject']);          //商品名称，（中介交易时必填）
        //系统可选参数
        $reqHandler->setParameter("sign_type", "MD5");  	 	  //签名方式，默认为MD5，可选RSA
        $reqHandler->setParameter("service_version", "1.0"); 	  //接口版本号
        $reqHandler->setParameter("input_charset", "GBK");   	  //字符集
        $reqHandler->setParameter("sign_key_index", "1");    	  //密钥序号

        //业务可选参数
        $reqHandler->setParameter("attach", "");             	  //附件数据，原样返回就可以了
        $reqHandler->setParameter("product_fee", "");        	  //商品费用
        $reqHandler->setParameter("transport_fee", "");      	  //物流费用
        $reqHandler->setParameter("time_start", date("YmdHis"));  //订单生成时间
        $reqHandler->setParameter("time_expire", "");             //订单失效时间

        $reqHandler->setParameter("buyer_id", "");                //买方财付通帐号
        $reqHandler->setParameter("goods_tag", "");               //商品标记
        $reqHandler->setParameter("trade_mode","1");              //交易模式（1.即时到帐模式，2.中介担保模式，3.后台选择（卖家进入支付中心列表选择））
        $reqHandler->setParameter("transport_desc","");              //物流说明
        $reqHandler->setParameter("trans_type","1");              //交易类型
        $reqHandler->setParameter("agentid","");                  //平台ID
        $reqHandler->setParameter("agent_type","");               //代理模式（0.无代理，1.表示卡易售模式，2.表示网店模式）
        $reqHandler->setParameter("seller_id","");                //卖家的商户号


        //请求的URL
        $reqUrl = $reqHandler->getRequestURL();

        //获取debug信息,建议把请求和debug信息写入日志，方便定位问题
        /**/
//        $debugInfo = $reqHandler->getDebugInfo();
//        echo "<br/>" . $reqUrl . "<br/>";
//        echo "<br/>" . $debugInfo . "<br/>";

        header("Location:" . $reqUrl);
        exit;
    }

    /**
     * 异步回调
     * @return string
     */
    public function notify_alipay()
    {
        $config       = $this->alipay_config;
        $alipayNotify = new \AlipayNotify($config); //计算得出通知验证结果
        if ($result = $alipayNotify->verifyNotify()) {
            //验签成功
            if ($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
                $ordersn     = $_POST['out_trade_no'];
                //成功后的后续操作/**
                paySuccessProcess($ordersn);
                return true;
            }else{
                $member  = get_member_account();
                $memInfo = member_get($member['openid'],'mobile');
                logRecord("{$memInfo['mobile']}用户支付业务错误",'payError');
                $this->error = '业务错误';
                return false;
            }
        }else{
            //验证失败  记录日志
            $member  = get_member_account();
            $memInfo = member_get($member['openid'],'mobile');
            logRecord("{$memInfo['mobile']}用户支付异步签名验证失败",'payError');
            $this->error = '支付失败';
            return false;
        }
    }

    /**
     * 同步回调  返回的数据
     *Array
    (
    [mod] => mobile
    [name] => shopwap
    [do] => alipay
    [op] => returnurl
    [body] => 测试商品
    [buyer_email] => 791845283@qq.com
    [buyer_id] => 2088802661101009
    [exterface] => create_direct_pay_by_user
    [is_success] => T
    [notify_id] => RqPnCoPT3K9%2Fvwbh3InYwe9UQaecKY9y3krILMLAzIFwEVVFOIAEcfZx4sSZwAlhKQTA
    [notify_time] => 2017-06-22 17:27:33
    [notify_type] => trade_status_sync
    [out_trade_no] => sn099239283879
    [payment_type] => 1
    [seller_email] => 33413434@qq.com
    [seller_id] => 2088321009666241
    [subject] => sn099239283879
    [total_fee] => 0.01
    [trade_no] => 2017062221001004000219681644
    [trade_status] => TRADE_SUCCESS
    [sign] => 280e4387a81f3e7cd2f28aa0f4203a12
    [sign_type] => MD5
    )
     */
    public function return_alipay()
    {
        $config = $this->alipay_config;
        $alipayNotify  = new \AlipayNotify($config); //计算得出通知验证结果
        $verify_result = $alipayNotify->verifyReturn();
        if ($verify_result) {
            //验证成功
            if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                $ordersn     = $_GET['out_trade_no'];
                //成功后的后续操作/**
                paySuccessProcess($ordersn);
                return true;
            } else {
                $member  = get_member_account();
                $memInfo = member_get($member['openid'],'mobile');
                logRecord("{$memInfo['mobile']}用户支付业务错误",'payError');
                $this->error = '业务错误';
                return false;
            }
        } else {
            //验证失败  记录日志
            $member  = get_member_account();
            $memInfo = member_get($member['openid'],'mobile');
            logRecord("{$memInfo['mobile']}用户支付异步签名验证失败",'payError');
            $this->error = '支付失败';
            return false;
        }
    }


}