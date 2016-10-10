<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
    public function index()
    {
        $data = M('user')->order('sort desc')->select();
        $list = array();
        catTree($list,$data);
        $userRole = C('userRole');
        $this->assign('userRole',$userRole);
        $this->assign('userData',$list);
        $this->display();
    }

    public function addUser()
    {
        if(IS_POST){

        }else{
            $userRole = C('userRole');
            $this->assign('userRole',$userRole);
            $this->display();
        }
    }
}