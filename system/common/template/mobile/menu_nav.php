<?php
$openid   = checkIsLogin();
$seting2  = globaSetting();
$kefu_qq  = getQQ_onWork($seting2);
?>
<!-- 导航 -->

<link href="<?php echo WEBSITE_ROOT ?>themes/default/__RESOURCE__/index/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<div id="menu_bg" data-wow-duration="1.6s">

    <div id="container">

        <a href="/"><div class="logo">
                <?php echo $seting2['shop_title']; ?>
            </div></a>

        <a href="<?php echo mobile_url('order',array('op'=>'index')); ?>" class="cx_btn"><i class="fa fa-calendar"></i> <b>订单查询</b></a>

        <div class="header-userInfo">
            <?php if($openid){ ?>
            <a href="<?php echo mobile_url('login',array('op'=>'logout')); ?>" class="login_btn"><i class="fa fa-user-circle-o"></i> <b>退出登录</b></a>
            <?php }else{ ?>
            <a href="<?php echo mobile_url('login',array('op'=>'signin')); ?>" class="login_btn"><i class="fa fa-user-circle-o"></i> <b>用户注册</b></a>
            <?php } ?>

            <ul id="menu">

                <li class="<?php if($_GP['do'] == 'index' || empty($_GP['do'])){ echo 'active';} ?>"><a href="/">首页</a></li>
                <li class="<?php if($_GP['do'] == 'games'){ echo 'active';} ?>"><a href="<?php echo mobile_url('games',array('op'=>'index')); ?>">游戏币种</a></li>
                <li class="<?php if($_GP['do'] == 'about'){ echo 'active';} ?>"><a href="<?php echo mobile_url('about',array('op'=>'index')); ?>">关于我们</a></li>

            </ul>

        </div>

    </div>

</div>

<!-- 漂浮 -->

<div class="pf">

    <a href="#page1"><div class="li0"><i class="fa fa-arrow-up"></i></div></a>

    <div class="li1"><i class="fa fa-phone"></i> <b><?php echo $seting2['shop_tel']; ?></b></div>
    <?php foreach($kefu_qq as $q_num => $one_qq){ ?>
    <div class="li1"><a href="<?php echo $one_qq; ?>" rel="nofollow"><i class="fa fa-qq"></i> <b><?php echo $q_num; ?></b></a></div>
    <?php } ?>
<!--    <div class="li2"><i class="fa fa-qrcode"></i></div>-->

</div>
<div class="pf_ewm"><img src="<?php echo WEBSITE_ROOT ?>themes/default/__RESOURCE__/index/images/qr-img.png" width="173" height="234"></div><!-- 二维码内容页 -->