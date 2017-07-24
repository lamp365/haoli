<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2017/7/18
 * Time: 21:57
 */
namespace home\controller;

class qrcodelogin extends \home\controller\base
{
    public function index()
    {
        $_GP = $this->request;
        if(!is_mobile_request()){
            message('请在微信中打开!',refresh(),'error');
        }
        if(empty($_GP['session_id'])){
            message('参数有误!,无法登陆!',refresh(),'error');
        }
        if($openid = checkIsLogin()){
            $res = mysqld_update('member',array('check_temp_sessionid'=>$_GP['session_id']),array('openid'=>$openid));
            if(!$res){
//                message('由于缓存,请在手机端进行退出后,再次扫码',refresh(),'error');
                $url = mobile_url('qrcodelogin',array('op'=>'index','session_id'=>$_GP['session_id']));
                member_logout($url);
                die();
            }

        }
        $seting = globaSetting();
        include themePage('qrcodelogin');

    }

    public function get_sessionid()
    {
        //获取session_id
        $session_id = get_sessionid();
        ajaxReturnData(1,'',array('session_id'=>$session_id));
    }

    public function checkLogin()
    {
        $_GP = $this->request;
        if(empty($_GP['session_id'])){
            ajaxReturnData(0,'参数有误!,无法登陆!');
        }
        $meminfo = mysqld_select("select * from ".table('member')." where check_temp_sessionid='{$_GP['session_id']}'");
        if(empty($meminfo)){
            ajaxReturnData(-1,'还未登陆!');
        }
        save_member_login('',$meminfo['openid']);
        mysqld_update('member',array('check_temp_sessionid'=>''),array('openid'=>$meminfo['openid']));
        ajaxReturnData(1,'登陆成功!');
    }

}