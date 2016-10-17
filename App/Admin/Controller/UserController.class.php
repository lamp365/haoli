<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
    public function index()
    {
        $count    = M('user')->count();
        $page     = new \Think\Page($count,20);
        $showpage = $page->show();
        $data     = M('user')->order('is_admin desc,id asc')->limit($page->firstRow.','.$page->listRows)->select();
        $userRole = C('userRole');
        $this->assign('userRole',$userRole);
        $this->assign('userData',$data);
        $this->assign('showpage',$showpage);
        $this->assign('count',$count);
        $this->display();
    }

    public function addUser()
    {
        if(IS_POST){
            $member = D('User');
            if($info = $member->create()) {
                if($member->add()) {
                    $this->success('注册成功！');
                } else {
                    $this->error('注册失败！');
                }
            } else {
                $msg = $member->getError();
                $this->error($msg);
            }
        }else{
            $userRole = C('userRole');
            $this->assign('userRole',$userRole);
            $this->display();
        }
    }

    public function findUser(){
        $keyword = I('post.keyword');
        if(is_int($keyword)){
            $where['mobile'] = array('like',"%{$keyword}%");
        }else{
            $where['name'] = array('like',"%{$keyword}%");
        }
        $user = M('user');
        $info = $user->field('id,name,email,mobile')->where($where)->select();
        if(empty($info)){
            die(showAjax('对不起，查无信息！','error'));
        }
        $html = '<div style="max-height: 300px;overflow-y: scroll">'.
                '<table class="table table-striped">
                    <thead>
                        <tr>
                        <th>id</th>
                        <th>名字</th>
                        <th>手机</th>
                        <th>地区</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach($info as $user){
            $html .="<tr>
                        <td>{$user['id']}</td>
                        <td>{$user['name']}</td>
                        <td>{$user['mobile']}</td>
                        <td>{$user['area']}</td>
                    </tr>";
        }
        $html .="</tbody></table></div>";
        echo showAjax($html);
    }

    function piliangAddUser(){
        $pid = I('get.pid');
        if(empty($pid)){
            die('参数有误！');
        }

        $name = D('Randname');
        $user = M('user');
        for($i=0; $i<5;$i++){
            if($i%2==0){
                $role = 3;
            }else{
                $role = 6;
            }
            $gname = $name->getName();
            $mobile = substr(mt_rand(100,999).time(),0,11);
            $data = array(
                'pid'=>$pid,
                'name'=>$gname,
                'mobile'=>$mobile,
                'pwd'=>md5Pwd('123456'),
                'roles_num'=>$role,
                'createtime'=>time(),
                'lasttime'=>time()
            );
            $user->add($data);
        }

        die("操作成功!");
    }

    function addAllUser(){
        $userData = M('user')->where("pid <> 0 and id>135")->select();
        foreach($userData as $arr){
            $id = $arr['id'];
            //查找子类有五个没有
            $fiveUser = M('user')->where("pid={$id}")->select();
            if(empty($fiveUser)){
                $j=0;
            }else{
                $leng = count($fiveUser);
               if($leng < 5){
                   $j = 5-$leng;
               }
            }

            $name = D('Randname');
            $user = M('user');
            for($k=$j; $k<5;$k++){
                if($k%2==0){
                    $role = 3;
                }else{
                    $role = 6;
                }
                $gname = $name->getName();
                $mobile = substr(mt_rand(10000,99999).time(),0,11);
                $data = array(
                    'pid'=>$id,
                    'name'=>$gname,
                    'mobile'=>$mobile,
                    'pwd'=>md5Pwd('123456'),
                    'roles_num'=>$role,
                    'createtime'=>time(),
                    'lasttime'=>time()
                );
                $user->add($data);
            }
            echo "id --- {$id}已经完成！<br/>";
        }
        die("操作成功!");
    }
}