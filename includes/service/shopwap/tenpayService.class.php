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


    public function returnUrl()
    {
        /* 商户号，上线时务必将测试商户号替换为正式商户号 */
        $partner =  $this->tenpay_config['partner'];
        /* 密钥 */
        $key =  $this->tenpay_config['key'];
        $resHandler = new \kevin365\tenpay\src\ResponseHandler();
        $resHandler->setKey($key);

        //判断签名
        if($resHandler->isTenpaySign()) {

            //通知id
            $notify_id = $resHandler->getParameter("notify_id");

            //通过通知ID查询，确保通知来至财付通
            //创建查询请求
            $queryReq = new \kevin365\tenpay\src\RequestHandler();
            $queryReq->init();
            $queryReq->setKey($key);
            $queryReq->setGateUrl("https://gw.tenpay.com/gateway/verifynotifyid.xml");
            $queryReq->setParameter("partner", $partner);
            $queryReq->setParameter("notify_id", $notify_id);

            //通信对象
            $httpClient = new \kevin365\tenpay\src\client\TenpayHttpClient();
            $httpClient->setTimeOut(5);
            //设置请求内容
            $httpClient->setReqContent($queryReq->getRequestURL());

            //后台调用
            if($httpClient->call()) {
                //设置结果参数
                $queryRes = new \kevin365\tenpay\src\client\ClientResponseHandler();
                $queryRes->setContent($httpClient->getResContent());
                $queryRes->setKey($key);

                //判断签名及结果
                //只有签名正确,retcode为0，trade_state为0才是支付成功
                if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" && $queryRes->getParameter("trade_state") == "0" && $queryRes->getParameter("trade_mode") == "1" ) {
                    //取结果参数做业务处理
                    $out_trade_no = $queryRes->getParameter("out_trade_no");
                    //财付通订单号
                    $transaction_id = $queryRes->getParameter("transaction_id");
                    //金额,以分为单位
                    $total_fee = $queryRes->getParameter("total_fee");
                    //如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
                    $discount = $queryRes->getParameter("discount");

                    //------------------------------
                    //处理业务开始
                    //------------------------------
                    ppd($out_trade_no);
                    paySuccessProcess($out_trade_no);
                    //处理数据库逻辑
                    //注意交易单不要重复处理
                    //!!!注意判断返回金额!!!

                    //------------------------------
                    //处理业务完毕
                    //------------------------------
                    return true;

                } else {
                    //错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
                    //echo "验证签名失败 或 业务错误信息:trade_state=" . $queryRes->getParameter("trade_state") . ",retcode=" . $queryRes->getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
                   $errMsg = "财付通验证签名失败 或 业务错误信息:trade_state=" . $queryRes->getParameter("trade_state") . ",retcode=" . $queryRes->getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg");
                    logRecord($errMsg,'payError');
                    $this->error = '支付失败！';
                    return false;
                }

                //获取查询的debug信息,建议把请求、应答内容、debug信息，通信返回码写入日志，方便定位问题
                /*
                echo "<br>------------------------------------------------------<br>";
                echo "http res:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
                echo "query req:" . htmlentities($queryReq->getRequestURL(), ENT_NOQUOTES, "GB2312") . "<br><br>";
                echo "query res:" . htmlentities($queryRes->getContent(), ENT_NOQUOTES, "GB2312") . "<br><br>";
                echo "query reqdebug:" . $queryReq->getDebugInfo() . "<br><br>" ;
                echo "query resdebug:" . $queryRes->getDebugInfo() . "<br><br>";
                */
            }else {
                //通信失败
                //echo "fail";
                //后台调用通信失败,写日志，方便定位问题，这些信息注意保密，最好不要打印给用户
//                echo "<br>订单通知查询失败:" . $httpClient->getResponseCode() ."," . $httpClient->getErrInfo() . "<br>";
                $errMsg = "财付通订单通知查询失败:" . $httpClient->getResponseCode() ."," . $httpClient->getErrInfo();
                logRecord($errMsg,'payError');
                $this->error = '支付失败！';
                return false;
            }
        } else {
            //签名错误
            $errMsg = "财付通签名错误";
            logRecord($errMsg,'payError');
            $this->error = '支付失败！';
            return false;
        }

    }

    public function notifyUrl()
    {

        /* 商户号，上线时务必将测试商户号替换为正式商户号 */
        $partner =  $this->tenpay_config['partner'];
        /* 密钥 */
        $key =  $this->tenpay_config['key'];

        /* 创建支付应答对象 */
        $resHandler = new \kevin365\tenpay\src\ResponseHandler();
        $resHandler->setKey($key);

        //判断签名
        if($resHandler->isTenpaySign()) {

            //通知id
            $notify_id = $resHandler->getParameter("notify_id");

            //通过通知ID查询，确保通知来至财付通
            //创建查询请求
            $queryReq = new \kevin365\tenpay\src\RequestHandler();
            $queryReq->init();
            $queryReq->setKey($key);
            $queryReq->setGateUrl("https://gw.tenpay.com/gateway/verifynotifyid.xml");
            $queryReq->setParameter("partner", $partner);
            $queryReq->setParameter("notify_id", $notify_id);

            //通信对象
            $httpClient = new \kevin365\tenpay\src\client\TenpayHttpClient();
            $httpClient->setTimeOut(5);
            //设置请求内容
            $httpClient->setReqContent($queryReq->getRequestURL());

            //后台调用
            if($httpClient->call()) {
                //设置结果参数
                $queryRes = new \kevin365\tenpay\src\client\ClientResponseHandler();
                $queryRes->setContent($httpClient->getResContent());
                $queryRes->setKey($key);

                //判断签名及结果
                //只有签名正确,retcode为0，trade_state为0才是支付成功
                if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" && $queryRes->getParameter("trade_state") == "0" && $queryRes->getParameter("trade_mode") == "1" ) {
                    //取结果参数做业务处理
                    $out_trade_no = $queryRes->getParameter("out_trade_no");
                    //财付通订单号
                    $transaction_id = $queryRes->getParameter("transaction_id");
                    //金额,以分为单位
                    $total_fee = $queryRes->getParameter("total_fee");
                    //如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
                    $discount = $queryRes->getParameter("discount");

                    //------------------------------
                    //处理业务开始
                    //------------------------------
                    paySuccessProcess($out_trade_no);
                    //处理数据库逻辑
                    //注意交易单不要重复处理
                    //注意判断返回金额

                    //------------------------------
                    //处理业务完毕
                    //------------------------------
                   return true;

                } else {
                    //错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
                    //echo "验证签名失败 或 业务错误信息:trade_state=" . $queryRes->getParameter("trade_state") . ",retcode=" . $queryRes->getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
                    $errMsg = "财付通验证签名失败 或 业务错误信息:trade_state=" . $queryRes->getParameter("trade_state") . ",retcode=" . $queryRes->getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg");
                    logRecord($errMsg,'payError');
                    $this->error = '支付失败！';
                    return false;
                }

                //获取查询的debug信息,建议把请求、应答内容、debug信息，通信返回码写入日志，方便定位问题
                /*
                echo "<br>------------------------------------------------------<br>";
                echo "http res:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
                echo "query req:" . htmlentities($queryReq->getRequestURL(), ENT_NOQUOTES, "GB2312") . "<br><br>";
                echo "query res:" . htmlentities($queryRes->getContent(), ENT_NOQUOTES, "GB2312") . "<br><br>";
                echo "query reqdebug:" . $queryReq->getDebugInfo() . "<br><br>" ;
                echo "query resdebug:" . $queryRes->getDebugInfo() . "<br><br>";
                */
            }else {
                //通信失败
                //后台调用通信失败,写日志，方便定位问题
                //echo "<br>call err:" . $httpClient->getResponseCode() ."," . $httpClient->getErrInfo() . "<br>";
                $errMsg =  "财付通call err:" . $httpClient->getResponseCode() ."," . $httpClient->getErrInfo();
                logRecord($errMsg,'payError');
                $this->error = '支付失败！';
                return false;
            }


        } else {
            //回调签名错误
            //echo "<br>签名失败<br>";
            $errMsg = "财付通签名失败";
            logRecord($errMsg,'payError');
            $this->error = '支付失败！';
            return false;
        }

        //获取debug信息,建议把debug信息写入日志，方便定位问题
        //echo $resHandler->getDebugInfo() . "<br>";

    }

}