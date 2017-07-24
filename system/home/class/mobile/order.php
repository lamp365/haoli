<?php
namespace home\controller;

class order extends \home\controller\base
{
	public function index()
	{
		$_GP    = $this->request;
        $seting = globaSetting();
        $member    = array();
        $orderlist = array();
        if($openid = checkIsLogin()){
            //未支付的自动关闭
            order_auto_close();
            $member    = member_get($openid);
            $orderlist = mysqld_selectall("select * from ".table('shop_order')." where openid='{$openid}' order by id desc limit 15");
        }
		include themePage('orderlist');
	}

    public function choosepay()
    {
        $_GP     = $this->request;
        $seting  = globaSetting();
        $orderid = $_GP['orderid'];
        if(empty($orderid)){
            echo '参数有误!';
            return '';
        }
        include themePage('choosepay');
    }

	public function show_number()
    {
        $_GP    = $this->request;
        $openid = checkIsLogin();
        if(!$openid){
            ajaxReturnData(0,'请您先登录!');
        }
        if(empty($_GP['orderid'])){
            ajaxReturnData('0','参数有误!');
        }
        $order = mysqld_select("select * from ".table('shop_order')." where id={$_GP['orderid']}");
        if($openid != $order['openid']){
            ajaxReturnData('0','对不起,订单不存在!');
        }
        if($order['status'] == 0 || $order['status'] == -1){
            ajaxReturnData('0','对不起,订单未完成支付!');
        }
        $sql = 'select g.dish_number,d.title from '.table('shop_order_goods')." as g left join ".table('shop_dish')." as d on g.goodsid=d.id where g.orderid={$order['id']}";
        $goods = mysqld_selectall($sql);
        ajaxReturnData(1,'',$goods);
    }

    public function member()
    {
        $_GP    = $this->request;
        $openid = checkIsLogin();
        if(!$openid){
           message('请您先登录!',refresh(),'error');
        }
        $u_data['nickname'] = $_GP['nickname'];
        $u_data['QQ']       = $_GP['QQ'];
        mysqld_update('member',$u_data,array('openid'=>$openid));
        message('操作成功!',refresh(),'success');
    }

    public function pwd()
    {
        $_GP    = $this->request;
        $openid = checkIsLogin();
        if(!$openid){
           message('请您先登录!',refresh(),'error');
        }
        if(empty($_GP['old_pwd'])){
            message('请输入旧密码!',refresh(),'error');
        }
        $_GP['pwd']   = trim($_GP['pwd']);
        $_GP['repwd'] = trim($_GP['repwd']);
        if(empty($_GP['pwd']) || empty($_GP['repwd'])){
            message('请输入新密码!',refresh(),'error');
        }
        if($_GP['pwd'] != $_GP['repwd']){
            message('两次密码不一致!',refresh(),'error');
        }
        $member = member_get($openid);
        if(encryptPassword($_GP['old_pwd']) != $member['pwd']){
            message('旧密码与用户不匹配!',refresh(),'error');
        }
        mysqld_update('member',array('pwd'=>encryptPassword($_GP['pwd'])),array('openid'=>$openid));
        message('操作成功!',refresh(),'success');
    }

    public function binduser()
    {
        $_GP    = $this->request;
        $openid = checkIsLogin();
        if(!$openid){
            message('请您先登录!',refresh(),'error');
        }
        if(empty($_GP['mobile'])){
            message('请输入登录账户!',refresh(),'error');
        }
        if(!is_numeric($_GP['mobile']) || strlen($_GP['mobile']) > 11){
            message('账户必须是数字,且不超过11位');
        }
        if(empty($_GP['pwd'])){
            message('请输入密码!',refresh(),'error');
        }
        if($_GP['pwd'] != $_GP['repwd']){
            message('两次密码不一致!',refresh(),'error');
        }
        $mem = member_get_bymobile($_GP['mobile']);
        if($mem){
            //存在的用户 如果密码跟现在的一样，说明是该用户的
            if($mem['pwd'] == encryptPassword($_GP['pwd'])){
                $new_member = member_get($openid);
                if(($mem['mem_from'] == 3 && $new_member['mem_from'] == 1) || ($mem['mem_from'] == 1 && $new_member['mem_from'] == 1)){
                    message('该绑定账户已绑定其他微信！',refresh(),'error');
                }else if(($mem['mem_from'] == 3 && $new_member['mem_from'] == 2) || $mem['mem_from'] == 2 && $new_member['mem_from'] == 2){
                    message('该绑定账户已绑定其他QQ！',refresh(),'error');
                }
                //要绑定的账户
                $old_openid = $mem['openid'];
                mysqld_delete('member',array('openid'=>$openid));
                mysqld_update('shop_order',array('openid'=>$old_openid),array('openid'=>$openid));
                mysqld_update('shop_order_goods',array('openid'=>$old_openid),array('openid'=>$openid));

                if($mem['mem_from'] == 0){
                    mysqld_update('member',array(
                        'mem_from'   => $new_member['mem_from']
                    ),array('openid' =>$old_openid));
                }else{
                    mysqld_update('member',array(
                        'mem_from'   => 3
                    ),array('openid' =>$old_openid));
                }
                if($new_member['mem_from'] == 1){
                    //将微信表的openid更新过来
                    mysqld_update('weixin_wxfans',array('openid'=>$old_openid),array('openid'=>$openid));
                }else if($new_member['mem_from'] == 2){
                    //将QQ表的openid更新过来
                    mysqld_update('qq_qqfans',array('openid'=>$old_openid),array('openid'=>$openid));
                }

            }else{
                //该账户已经存在
                message('该账户已经存在!',refresh(),'error');
            }
        }else{
            mysqld_update('member',array('pwd'=>encryptPassword($_GP['pwd']),'mobile'=>$_GP['mobile']),array('openid'=>$openid));
        }

        message('绑定成功！',refresh(),'success');
    }

    public function checkIsPay()
    {
        $_GP    = $this->request;
        $openid = checkIsLogin();
        if(!$openid){
            ajaxReturnData(0,'请您先登录!');
        }
        if(empty($_GP['ordersn'])){
            ajaxReturnData(-1,'参数有误!');
        }
        $find = mysqld_select("select * from ".table('shop_order')." where ordersn='{$_GP['ordersn']}'");
        if(empty($find)){
            ajaxReturnData(-1,'该订单不存在!');
        }
        if($find['status'] == 1){
            ajaxReturnData(1,'支付成功!');
        }
        ajaxReturnData(0,'订单等待支付!');
    }
}