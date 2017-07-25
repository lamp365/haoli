<?php
namespace home\controller;

class about extends \home\controller\base
{
	public function index()
	{
		$_GP     = $this->request;
		$seting  = globaSetting();
        $kefuQQ  = getQQ_onWork($seting);
		include themePage('about');
	}

	public function cc()
	{
		$tenpay_config = array(
			'partner' => '1486474181',
			'key' => '7df7a938fc9449b17f7b9b4f5127c59a',
			'return_url' => 'http://baidu.com',
			'notify_url' => 'http://baidu.com',
		);
		$a = new \kevin365\tenpay\Tenpay($tenpay_config);
		$data['ordersn'] = date('YmdHis').uniqid();
		$data['title']   = '测试商品';
		$data['price']   = '1';
		$a->pay($data);
	}
}