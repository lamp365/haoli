<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>『<?php echo C('webName');?>』后台管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/Libs/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/main.css"/>
    <script type="text/javascript" src="/Public/Admin/js/libs/modernizr.min.js"></script>
     
</head>
<body>
<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <h1 class="topbar-logo none"><a href="/Admin" class="navbar-brand">后台管理</a></h1>
            <ul class="navbar-list clearfix">
                <li><a class="on" href="/Admin">首页</a></li>
                <li><a href="" target="_blank">网站首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <li><a href="<?php echo U('User/root');?>">管理员</a></li>
                <li><a href="<?php echo U('User/pwd');?>">修改密码</a></li>
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="clearfix">

    <div class="sidebar-wrap">
    <div class="sidebar-title">
        <h1>菜单</h1>
    </div>
    <div class="sidebar-content">
        <ul class="sidebar-list">
            <li>
                <a href="#"><i class="icon-font">&#xe003;</i>常用操作</a>
                <ul class="sub-menu">
                    <li><a href="<?php echo U('User/index');?>"><i class="icon-font">&#xe008;</i>用户管理</a></li>
                    <li><a href="design.html"><i class="icon-font">&#xe005;</i>博文管理</a></li>
                    <li><a href="design.html"><i class="icon-font">&#xe006;</i>分类管理</a></li>
                    <li><a href="design.html"><i class="icon-font">&#xe004;</i>留言管理</a></li>
                    <li><a href="design.html"><i class="icon-font">&#xe012;</i>评论管理</a></li>
                    <li><a href="design.html"><i class="icon-font">&#xe052;</i>交易管理</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="icon-font">&#xe018;</i>系统管理</a>
                <ul class="sub-menu">
                    <li><a href="system.html"><i class="icon-font">&#xe017;</i>系统设置</a></li>
                    <li><a href="system.html"><i class="icon-font">&#xe037;</i>清理缓存</a></li>
                    <li><a href="system.html"><i class="icon-font">&#xe046;</i>数据备份</a></li>
                    <li><a href="system.html"><i class="icon-font">&#xe045;</i>数据还原</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

    <!--/sidebar-->
    <div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list">
                
    <i class="icon-font"></i><a href="/Admin">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">用户管理</span>

            </div>
        </div>

        
    <div class="search-wrap">
        <div class="search-content">
            <form action="/Admin/User" method="post">
                <table class="search-tab">
                    <tr>
                        <th width="80">身份选择:</th>
                        <td>
                            <select name="userRole" id="" class="common-text">
                                <option value="0">全部</option>

                                <?php if(is_array($userRole)): $i = 0; $__LIST__ = $userRole;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($user); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

                            </select>
                        </td>
                        <th width="110" style="text-align: right">用户查询:</th>
                        <td><input class="common-text" placeholder="输入用户名或手机号" name="keyword" value="" id="" type="text"></td>
                        <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="result-wrap">
        <form name="myform" id="myform" method="post" action="/Admin/User/deleteUser">
            <div class="result-title">
                <div class="result-list">
                    成员(<font color="red"><?php echo ($count); ?></font>)人&nbsp;&nbsp;
                    <a href="<?php echo U('User/addUser');?>"><i class="icon-font"></i>新增成员</a>
                    <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                    <a id="updateOrd" href="<?php echo U('User/showUser');?>"><i class="icon-font"></i>查看用户</a>
                </div>
            </div>
            <div class="result-content">

                <?php if(empty($userData)): ?><p style="text-align: center; line-height: 50px;">暂无数据！</p>
                <?php else: ?>
                    <table class="result-tab" width="100%">
                        <tr>
                            <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>邮箱</th>
                            <th>手机号</th>
                            <th>身份</th>
                            <th>地区</th>
                            <th>通行证</th>
                            <th>注册时间</th>
                            <th>最后时间</th>
                            <th>操作</th>
                        </tr>

                        <?php if(is_array($userData)): $i = 0; $__LIST__ = $userData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><tr>
                                <td class="tc"><input name="id[]" value="<?php echo ($user['id']); ?>" type="checkbox"></td>
                                <td>
                                    <input name="ids[]" value="<?php echo ($user['id']); ?>" type="hidden">
                                    <?php echo ($user['id']); ?>
                                </td>
                                <td><?php echo ($user['name']); ?></td>
                                <td><?php echo checkIsEmail($user['email']);?></td>
                                <td><?php echo ($user['mobile']); ?></td>
                                <td><?php echo ($userRole[$user['roles_num']]); ?></td>
                                <td><?php echo ($user['area']); ?></td>
                                <td><?php echo ($user['go_hk_num']); ?></td>
                                <td><?php echo (date("Y-m-d",$user['createtime'])); ?></td>
                                <td><?php echo (date("Y-m-d",$user['lasttime'])); ?></td>
                                <td>
                                    <a class="link-update" href="/Admin/User/editUser/id/<?php echo ($user['id']); ?>">修改</a>
                                    <a class="link-del" href="/Admin/User/deleteUser/id/<?php echo ($user['id']); ?>" onclick="confirm('请慎重！确定要删除么？')">删除</a>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>


                    </table>
                    <div class="list-page"> <?php echo ($showpage); ?></div><?php endif; ?>
            </div>
        </form>
    </div>



    </div>
    <!--/main-->
</div>

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalLabel"> </h3>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" class="modal_suer" style="display: none">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script src="/Public/Libs/bootstrap/js/jquery.js"></script>
<script src="/Public/Libs/bootstrap/js/bootstrap.min.js"></script>
<script src="/Public/Admin/js/common.js"></script>

    <script>
        $(".allChoose").click(function(){
            isCheck = this.checked;
            $("input[name='id[]']").each(function(){
                this.checked = isCheck;
            })
        })
        $("#batchDel").click(function(){
            var num =0;
            $("input[name='id[]']").each(function(){
                if(this.checked){
                    num ++;
                }
            })
            if(num == 0){
                tip('对不起，请选则用户','danger',2000);
                return;
            }
            $("#myform").submit();
        })
    </script>

</body>
</html>