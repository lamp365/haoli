<?php
/**
 * Created by PhpStorm.
 * User: 刘建凡
 * Date: 2017/4/20
 * Time: 18:39
 */

namespace home\controller;
use  home\controller;

class login extends \home\controller\base{


    //没有op默认显示 index
    public function index()
    {

        include themePage('login');
    }


    //表单提交 操作登录
    public function signup()
    {
        $_GP = $this->request;

        $loginService = new \service\shopwap\loginService();
        $res = $loginService->do_login($_GP);
        if($res){
            $url =   to_member_loginfromurl();
            message('登录成功！',$url,'success');
        }else{
            message($loginService->getError(),refresh(),'error');
        }
    }


    /**
     * 注册
     * Array
    (
    [mod] => mobile
    [name] => home
    [do] => login
    [op] => signup
    [QQ] => 324234
    [pwd] => 34324
    [repwd] => 23423432
    [dosub] => 1
    )
     */
    public function signin()
    {
        $seting  = globaSetting();
        $_GP = $this->request;
        if(checksubmit('dosub')){
            $loginService = new \service\shopwap\loginService();
            //先检测数据
            $res = $loginService->do_checksignin($_GP);
            if(!$res){
                message($loginService->getError(),refresh(),'error');
            }

            //开始注册
            $res = $loginService->do_signin($_GP);
            if($res){
                message('注册成功！',to_member_loginfromurl(),'success');
            }else{
                message($loginService->getError(),refresh(),'error');
            }
        }
        include themePage('signin');
    }

    public function logout()
    {
        unset($_SESSION["account"]);

        unset($_SESSION["addons_check"]);

        session_destroy();

        session_start();
        header("location:".WEBSITE_ROOT);
    }
}