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
                
                     <i class="icon-font">&#xe06b;</i><span>欢迎使用『<?php echo C('webName');?>』内部管理系统。</span>
                
            </div>
        </div>

        
    <div class="result-wrap">
        <div class="result-title">
            <h1>系统基本信息</h1>
        </div>
        <div class="result-content">
            <ul class="sys-info-list">
                <li>
                    <label class="res-lab">操作系统</label><span class="res-info">WINNT</span>
                </li>
                <li>
                    <label class="res-lab">运行环境</label><span class="res-info">Apache/2.2.21 (Win64) PHP/5.3.10</span>
                </li>
                <li>
                    <label class="res-lab">PHP运行方式</label><span class="res-info">apache2handler</span>
                </li>
                <li>
                    <label class="res-lab">静静设计-版本</label><span class="res-info">v-0.1</span>
                </li>
                <li>
                    <label class="res-lab">上传附件限制</label><span class="res-info">2M</span>
                </li>
                <li>
                    <label class="res-lab">北京时间</label><span class="res-info">2014年3月18日 21:08:24</span>
                </li>
                <li>
                    <label class="res-lab">服务器域名/IP</label><span class="res-info">localhost [ 127.0.0.1 ]</span>
                </li>
                <li>
                    <label class="res-lab">Host</label><span class="res-info">127.0.0.1</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="result-wrap">
        <div class="result-title">
            <h1>使用帮助</h1>
        </div>
        <div class="result-content">
            <ul class="sys-info-list">
                <li>
                    <label class="res-lab">官方交流网站：</label><span class="res-info"><a href="http://www.mycodes.net/" target="_blank">灏利发展有限公司</a></span>
                </li>
                <li>
                    <label class="res-lab">官方技术支持：</label><span class="res-info"><a class="qq-link" target="_blank" href="http://dayblog.cn">天天博客</a> </span>
                </li>
            </ul>
        </div>
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
 
</body>
</html>