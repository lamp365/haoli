<?php
namespace home\controller;

class member extends \home\controller\base
{
	public function binduser()
	{
		$_GP     = $this->request;
        $openid  = checkIsLogin();
        if(!$openid){
            message('请您先登录!',refresh(),'error');
        }
        $memInfo = member_get($openid,'mobile');
        if(!empty($memInfo['mobile'])){
            message('当前用户已经绑定过了!',refresh(),'error');
        }
		include themePage('binduser');
	}
}