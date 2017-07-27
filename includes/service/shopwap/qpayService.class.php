<?php

namespace service\shopwap;


class qpayService extends \service\publicService
{
    private $qpay_config = array(
        'MCH_ID'         => '1486419881',   //QQ钱包商户号
        'SUB_MCH_ID'     => '',   //子账户号
        'MCH_KEY'        => '21212',   //api密钥
        'CERT_FILE_PATH' => '',   //证书私钥
        'KEY_FILE_PATH'  => '',  //证书公钥
        'NOTIFY_URL'     => '',   //成功回调地址
    );

    /**
     * 构造函数
     * @param type $data
     */
    public function __construct() {
        parent::__construct();
        $payment = mysqld_select("SELECT * FROM " . table('payment') . " WHERE  enabled=1 and code='qpay' limit 1");
        $configs = unserialize($payment['configs']);
        $this->qpay_config['MCH_ID']      = $configs['qpay_MCH_ID'];
        $this->qpay_config['MCH_KEY']     = $configs['qpay_MCH_KEY'];
        $this->qpay_config['NOTIFY_URL']  =  mobile_url('qpay',array('name'=>'home','op'=>'notifyUrl'));
    }

    /**
     * 支付宝支付
     * @param type [] 接口参数
     * @return type []
     */
    public function qpay($data = array())
    {
        if(empty($data['subject'])){
            $this->error = '标题不能为空！';
            return false;
        }
        if(empty($data['out_trade_no']) || empty($data['total_fee'])){
            $this->error = '订单编号和金额不能为空！';
            return false;
        }
        $config = $this->qpay_config;

        $params = array(
            "out_trade_no"  => $data['out_trade_no'],
            "sub_mch_id"    => $config['SUB_MCH_ID'],
            "mch_id"        => $config['MCH_ID'],
            "body"          => $data['subject'],
//            "device_info"   => 'WP00000001',
            "fee_type"      => 'CNY',
            "notify_url"    => $config['NOTIFY_URL'],
            "spbill_create_ip"  => $_SERVER['REMOTE_ADDR'],
            "total_fee"         => $data['total_fee'],
            "trade_type"        => 'NATIVE',
        );

        //api调用
        $qpayApi = new \kevin365\tenpay\qpay\QpayMchAPI('https://qpay.qq.com/cgi-bin/pay/qpay_unified_order.cgi', null, 10,$config);
        $ret    = $qpayApi->reqQpay($params);
        $Qpay   = new \kevin365\tenpay\qpay\QpayMchUtil();
        $result = $Qpay->xmlToArray($ret);

        //最后得到code_url生成二维码，用手机扫码可完成支付
        //商户根据实际情况设置相应的处理流程
        if ($result["return_code"] == "FAIL") {
            //商户自行增加处理流程
            $this->error = "通信出错：".$result['return_msg'];
            logRecord("qq支付通信出错：".$result['return_msg'],'payError');
            return false;
        } elseif ($result["result_code"] == "FAIL") {
            //商户自行增加处理流程
            $this->error = "通信出错：".$result['err_code_des'];
            logRecord("qq支付通信出错：".$result['err_code_des'],'payError');
            return false;
        } elseif ($result["code_url"] != NULL) {
            //从统一支付接口获取到code_url
            $code_url = $result["code_url"];
            return $code_url;
        }
        $this->error = "未知错误";
        logRecord("qq支付未知错误！",'payError');
        return false;
    }

    /**
     * 异步回调
     * @return string
     */
    public function notifyUrl()
    {
        $config       = $this->qpay_config;
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        //在 PHP7 下不能获取数据，使用 php://input 代替
        if( !$xml ){
            $xml = file_get_contents("php://input");
        }

        $Qpay   = new \kevin365\tenpay\qpay\QpayMchUtil();
        $notifyData = $Qpay->xmlToArray($xml);
        /**
         * array (
         * 'bank_type' => 'BALANCE',
         * 'cash_fee' => '1',
         * 'fee_type' => 'CNY',
         * 'mch_id' => '1486419881',
         * 'nonce_str' => '9f101b952d28b213996a15f346f5bd60',
         * 'out_trade_no' => '201762646597985b966171',
         * 'sign' => '6E00258E8A541475F3DA30F6AE5C518C',
         * 'time_end' => '20170727142132', 'total_fee' => '1',
         * 'trade_state' => 'SUCCESS',
         * 'trade_type' => 'APP',
         * 'transaction_id' => '14864198816012201707271607465870',
         * ) 14:21:42 | array ( 'bank_type' => 'BALANCE', 'cash_fee' => '1', 'fee_type' => 'CNY', 'mch_id' => '1486419881', 'nonce_str' => '6407f64bc1baaff5694e391d15af2f73', 'out_trade_no' => '201762646597985b966171', 'sign' => '5923C5B6008A5603F7E78A7DABD5942E', 'time_end' => '20170727142132', 'total_fee' => '1', 'trade_state' => 'SUCCESS', 'trade_type' => 'APP', 'transaction_id' => '14864198816012201707271607465870', ) 14:21:58 | array ( 'bank_type' => 'BALANCE', 'cash_fee' => '1', 'fee_type' => 'CNY', 'mch_id' => '1486419881', 'nonce_str' => '477f41461c23e7e6460a3bcdf49abaf3', 'out_trade_no' => '201762646597985b966171', 'sign' => 'F0105D21AE1750D319933164F04E6078', 'time_end' => '20170727142132', 'total_fee' => '1', 'trade_state' => 'SUCCESS', 'trade_type' => 'APP', 'transaction_id' => '14864198816012201707271607465870', )
         */
        $returnSign = $notifyData['sign'];
        unset($notifyData['sign']);
        $sign = $Qpay->getSign($notifyData,$config['MCH_KEY']);//本地签名
        if($sign != $returnSign){
            $this->error = "签名错误";
            logRecord("qq支付签名错误！",'payError');
            return false;
        }

        if ( $notifyData["trade_state"] == "FAIL" ) {
            //此处应该更新一下订单状态，商户自行增删操作
            $this->error = "通信出错";
            logRecord("qq支付通信出错！",'payError');
            return false;
        } elseif ( $notifyData["trade_state"] == "FAIL" ){
            //此处应该更新一下订单状态，商户自行增删操作
            $this->error = "业务出错";
            logRecord("qq支付业务出错！",'payError');
            return false;
        } else {
            //此处应该更新一下订单状态，商户自行增删操作  支付成功！
            paySuccessProcess($notifyData['out_trade_no']);
            return true;
        }
    }

    /**
     * 同步回调  返回的数据
     */
    public function returnUrl()
    {

    }


}