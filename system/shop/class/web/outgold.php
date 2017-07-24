<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2017/7/17
 * Time: 18:13
 */
namespace  shop\controller;

class outgold extends \common\controller\basecontroller
{
    public function index()
    {
        $_GP = $this->request;
        //验证管理员是否绑定前台用户
        $userid   = $_SESSION['account']['id'];
        $mem_user = mysqld_select('select * from '.table('user')." where id = {$userid}");
        $mem_qq   = $mem_user['mobile'];
        if(empty($mem_qq)){
           $url = web_url('outgold',array('op'=>'binduser'));
           message('请先绑定一个前台用户',$url,'error');
        }
        $meminfo = member_get_bymobile($mem_qq);
        if(empty($meminfo)){
            mysqld_update('user',array('mobile'=>0),array('id'=>$_SESSION['account']['id']));
            $url = web_url('outgold',array('op'=>'binduser'));
            message('请先绑定一个前台用户',$url,'error');
        }

        $service   = new \service\shop\outgoldService();
        $bank_list = $service->get_bank_list($meminfo['openid']);
        if(empty($bank_list['all'])){
            $url = web_url('outgold',array('op'=>'setbank'));
            message('请先设置提款账户！',$url,'error');
        }
        //平台总收入
        $sys_money = mysqld_select("select * from ".table('shop_money'));
        $seting    = globaSetting();

        //本月技术提成
        $jishuMoney = $service->jishuMoney($seting['jishu_rate']);

        include page('outgold/index');
    }

    public function binduser()
    {
        $_GP = $this->request;
        if(checksubmit('sub')){
            if(empty($_GP['mobile'])){
                message('请输入前台用户账号',refresh(),'error');
            }
            $mem = member_get_bymobile($_GP['mobile'],'pwd');
            if(empty($mem)){
                message('用户不存在！',refresh(),'error');
            }
            if(encryptPassword($_GP['pwd']) != $mem['pwd']){
                message('前台用户账号与密码不匹配',refresh(),'error');
            }
            mysqld_update('user',array('mobile'=>$_GP['mobile']),array('id'=>$_SESSION['account']['id']));
            $url = web_url('outgold',array('op'=>'index'));
            message('操作成功！',$url,'success');
        }
        include page('outgold/binduser');
    }

    public function banklist()
    {
        $_GP = $this->request;
        //验证管理员是否绑定前台用户
        $userid   = $_SESSION['account']['id'];
        $mem_user = mysqld_select('select * from '.table('user')." where id = {$userid}");
        $mem_qq   = $mem_user['mobile'];
        if(empty($mem_qq)){
            $url = web_url('outgold',array('op'=>'binduser'));
            message('请先绑定一个前台用户',$url,'error');
        }
        $meminfo = member_get_bymobile($mem_qq);
        if(empty($meminfo)){
            mysqld_update('user',array('mobile'=>0),array('id'=>$_SESSION['account']['id']));
            $url = web_url('outgold',array('op'=>'binduser'));
            message('请先绑定一个前台用户',$url,'error');
        }

        //获取店铺法人的 银行卡账户信息
        $service    = new \service\shop\outgoldService();
        $bank_list  = $service->get_bank_list($meminfo['openid']);
        if(!is_array($bank_list)){
            //说明返回的是 false  app可以提示 不是管理员  pc则不显示数据不提示
            $bank_list  = array('all'=>array());
        }
        include page('outgold/banklist');
    }

    public function setbank()
    {
        $_GP = $this->request;
        $userid   = $_SESSION['account']['id'];
        $mem_user = mysqld_select('select * from '.table('user')." where id = {$userid}");
        $mem_qq   = $mem_user['mobile'];
        if(empty($mem_qq)){
            $url = web_url('outgold',array('op'=>'binduser'));
            message('请先绑定一个前台用户',$url,'error');
        }
        $meminfo = member_get_bymobile($mem_qq);
        if(empty($meminfo)){
            mysqld_update('user',array('mobile'=>0),array('id'=>$_SESSION['account']['id']));
            $url = web_url('outgold',array('op'=>'binduser'));
            message('请先绑定一个前台用户',$url,'error');
        }

        if(!empty($_GP['action'])){
            //修改账户
            $service = new \service\shop\outgoldService();
            $res     = $service->add_zhanghu($_GP,$meminfo['openid']);
            if($res){
                message('操作成功！',refresh(),'success');
            }else{
                message($service->getError(),refresh(),'error');
            }
        }

        if(!empty($_GP['id']))
            $edit_bank = mysqld_select("select * from ".table('member_bank')." where id={$_GP['id']} and openid='{$meminfo['openid']}'");
        else
            $edit_bank = array();

        include page('outgold/setbank');
    }

    //提现提交
    public function do_outgold()
    {
        $_GP = $this->request;
        $userid   = $_SESSION['account']['id'];
        $mem_user = mysqld_select('select * from '.table('user')." where id = {$userid}");
        $mem_qq   = $mem_user['mobile'];
        if(empty($mem_qq)){
            $url = web_url('outgold',array('op'=>'binduser'));
            message('请先绑定一个前台用户',$url,'error');
        }
        $meminfo = member_get_bymobile($mem_qq);
        if(empty($meminfo)){
            mysqld_update('user',array('mobile'=>0),array('id'=>$_SESSION['account']['id']));
            $url = web_url('outgold',array('op'=>'binduser'));
            message('请先绑定一个前台用户',$url,'error');
        }

        $accountService = new \service\shop\outgoldService();
        $res   = $accountService->do_outgold($_GP,$meminfo['openid']);
        if($res){
            message("系统正在审核中",refresh(),'success');
        }else{
            message($accountService->getError(),refresh(),'error');
        }
    }
}