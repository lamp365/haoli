<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>『<?php echo C('webName');?>』后台管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/main.css"/>
    <script type="text/javascript" src="/Public/Admin/js/libs/modernizr.min.js"></script>
    
    <!--<link href="/Public/Libs/city/css/bootstrap.css" rel="stylesheet" type="text/css" />-->
    <link href="/Public/Libs/city/css/city-picker.css" rel="stylesheet" type="text/css" />


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
<div class="container clearfix">

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
                
    <i class="icon-font"></i><a href="/Admin">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/Admin/User">用户管理</a><span class="crumb-step">&gt;</span><span>新增成员</span>

            </div>
        </div>

        
    <div class="result-content">
        <form action="/Admin/User/addUser" method="post" id="myform" name="myform" enctype="multipart/form-data">
            <table class="insert-tab" width="100%">
                <tbody><tr>
                    <th width="120"><i class="require-red">*</i>身份：</th>
                    <td>
                        <select name="userRole" id="catid" class="required common-text">
                            <option value="0">请选择</option>
                            <?php if(is_array($userRole)): $i = 0; $__LIST__ = $userRole;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($user); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><i class="require-red">*</i>父ID：</th>
                    <td>
                        <input class="common-text required" id="pid" name="pid" size="30" value="" type="text">
                    </td>
                </tr>
                <tr>
                    <th><i class="require-red">*</i>姓名：</th>
                    <td>
                        <input class="common-text required" id="title" name="name" size="30" value="" type="text">
                    </td>
                </tr>
                <tr>
                    <th><i class="require-red">*</i>手机号：</th>
                    <td><input class="common-text" name="mobile" size="30" value="" type="text"></td>
                </tr>
                <tr>
                    <th><i class="require-red">*</i>密码：</th>
                    <td><input class="common-text" name="pwd" size="30" value="" type="text"></td>
                </tr>
                <tr>
                    <th>邮箱：</th>
                    <td><input class="common-text" name="email" size="30" value="" type="text"></td>
                </tr>
                <tr>
                    <th>地区：</th>
                    <td>
                        <div id="distpicker" class="form-inline">
                            <div class="form-group">
                                <div style="position: relative;">
                                    <input id="city-picker3" class="form-control common-text" readonly type="text" value="江苏省/常州市/溧阳市" data-toggle="city-picker" style="width:400px;" name="area">
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-warning" id="reset" type="button">重置</button>
                                <button class="btn btn-danger" id="destroy" type="button">确定</button>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>头像：</th>
                    <td><input name="face" id="face" type="file"></td>
                </tr>
                <tr>
                    <th>内容：</th>
                    <td><textarea name="content" class="common-textarea" id="content" cols="30" style="width: 98%;" rows="10"></textarea></td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                        <input class="btn btn6" onclick="history.go(-1)" value="返回" type="button">
                    </td>
                </tr>
                </tbody></table>
        </form>
    </div>


    </div>
    <!--/main-->
</div>

    <script src="/Public/Libs/city/js/jquery.js"></script>
    <script src="/Public/Libs/city/js/city-picker.data.js"></script>
    <script src="/Public/Libs/city/js/city-picker.js"></script>
    <script src="/Public/Libs/city/js/main.js"></script>

</body>
</html>