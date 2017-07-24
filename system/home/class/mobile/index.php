<?php
namespace home\controller;

class index extends \home\controller\base
{
    //http://x.yupoo.com/
    //http://www.935ka.com/
    //http://www.935ka.com/category/DF68F4A1C12B54EE
	public function index()
	{
		$_GP = $this->request;
		$seting  = globaSetting();
        $openid  = checkIsLogin();
		include themePage('index');
	}
}