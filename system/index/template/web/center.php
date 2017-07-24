<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv=X-UA-Compatible content="IE=edge,chrome=1"/>
<title>首页</title>

<link rel="stylesheet" href="<?php echo RESOURCE_ROOT;?>/addons/common/bootstrap3/css/bootstrap.min.css" />   
<link rel="stylesheet" href="<?php echo RESOURCE_ROOT;?>/addons/index/css/c.css" />   
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_ROOT;?>/addons/common/fontawesome3/css/font-awesome.min.css" />
<script type="text/javascript" src="<?php echo RESOURCE_ROOT;?>addons/common/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_ROOT;?>addons/common/ueditor/third-party/highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_ROOT;?>/addons/common/laydate/laydate.js"></script>
<style type="text/css">
    body{
        background:none!important;
    }
    .payment-amount{
        width: 100%;
        height: 300px;
    }
    .payment-amount-area{
        float: left;
        width: 49%;
       
        overflow: hidden;
    }
    .number-area{
        float: left;
        width: 49%;
        margin-top: 45px;
    }
    .number-area ul{
        float: left;
        width: 50%;
    }
    .number-area img{
        width: 50px;
        height: 50px;
    }
    .payment-amount-area-left{
        float: left;
        overflow: hidden;
        width: 25%;
    }
    .payment-amount-area ul{
        width: 75%;
        float: left;
        overflow: hidden;
        font-size: 13px;
        line-height: 1.5;
        text-align: left;
    }
    .payment-amount-area li{
        float: left;
        overflow: hidden;
        width: 25%;
        padding-left: 2%;
        box-sizing: border-box;
    }
    .payment-left{
        float: left;
        width: 8%;
        min-width: 50px;
        text-align: right;
    }
    .payment-left img{
        max-width: 50px;
        height: 50px;
    }
    .payment-right{
        float: left;
        width: 70%;
        text-align: left;
        padding-left: 5%;
        color: #000;
        box-sizing: border-box;
        font-size: 14px;
        line-height: 1.5;
    }
    .payment-right div{
        height: 25px;
        line-height: 25px;
    }
    .access_amount{
        color: #000;
        line-height: 1.5;
    }
    .number-area li{
        font-size: 14px;
        margin: 15px 0 0 15px;
        overflow: auto;
    }
    .access-amount-head li,.shop-car-head li{
        float: left;
        margin-right: 7px;
    }
    .product-name-left{
        width: 60px;
        float: left;
    }
    .product-name-right{
        width: auto;
        float: left;
    }
    .workbench .today-presentation,.workbench .pending-order{
        box-sizing: initial;
    }
    .access-amount-table{
        margin-top: 20px;
    }
    .product-name-left img{
        width: 60px;
        height: 60px;
    }
    .product-name-time{
        margin-top: 15px;
    }
    .access-amount-table #begintime,.access-amount-table #endtime,.access-amount-table .search-input{
        height: 30px;
        border-radius: 4px;
        border: 1px solid #adadad;
        padding-left: 5px;
    }
    .shop-car-head #shopbegintime,.shop-car-head #shopendtime,.shop-car-head .search-input{
        height: 30px;
        border-radius: 4px;
        border: 1px solid #adadad;
        padding-left: 5px; 
    }
    .access-amount-head ul,.shop-car-head ul{
        overflow: auto;
        margin-bottom: 0;
    }
    .number-area i{
        width: 20px;
        text-align: center;
        display: inline-block;
    }
    .main-t{
        padding-top: 0;
    }
    .payment-amount-area h3{
        text-align: left;
        padding: 0;
        margin-left: 25px;
        font-size: 22px;
        font-weight: bold;
    }
    .payment-li-float{
        float: left;
        width: 50%;
    }

    .main-payment{
        width: 100%;
        overflow: hidden;
        background-color: #fff;
        border:1px solid #cad2e2;
    }
    .main-payment .small-title{
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 10px;
        font-size: 14px;
        line-height: 36px;
        height: 36px;
        font-weight: 700;
        color: #1b96a9;
        padding: 0 15px;
        background-color: #f7f7f7;
    }
    .access-amount-head,.shop-car-head{
        height: 36px;
        padding: 0;
        line-height: 36px;
        padding-left: 15px;
        border-bottom: none;
    }
    .access-amount-head .title,.shop-car-head .title{
        font-size: 16px;
        color: #1596ad;
        font-weight: 700;
    }
    .main-wrap .panel-default{
        border-color: #cad2e2;
        box-shadow: none;
    }
</style>
<script type="text/javascript">
	function hiddenall()
{
	 document.getElementById('container').style.display='none';
	   /* document.getElementById('container2').style.display='none';
	   document.getElementById('container3').style.display='none';*/
	
}
$(function () {

	hiddenall();
	document.getElementById('container').style.display='block';

});

</script>
</head>
<body >
<div class="main-wrap">
			

	<div class="workbench">

		<div class="clearfix" style="min-height:160px;">
			<div class="work-bench-r" >
		        <div class="pending-order">
		            <dl>
		                <dt><span class="title">平台吧收入</span></dt>
		                <dd><a href="javascript:;">总收入：<?php echo $sys_money['total_money']; ?></a></dd>
		                <dd><a href="javascript:;">总余额：<?php echo $sys_money['money']; ?></a></dd>
		                <dd><a href="javascript:;">技术分成：<?php echo number_format($jishuMoney,2);?></a></dd>
		            </dl>
		        </div>
		    </div>
		    <div class="work-bench-l" >
		        <!--begin 今日简报-->
		        <div class="today-presentation">
		            <dl>
		                <dt>
		                    <span class="totay-1">今日简报</span>
		                    <span class="totay-2">订单</span>
		                    <span class="totay-3">订单金额</span>
		                    <span class="totay-4">已退货单</span>
		                    <span class="totay-5">已退货金额</span>
		                </dt>
		                <dd>
		                    <span class="totay-1">今日</span>
		                    <span class="totay-2"><?php echo $todayordercount ?>笔</span>
		                    <span class="totay-3">￥<?php echo $todayorderprice ?></span>
		                    <span class="totay-4"><?php echo $todayordercount_re ?>笔</span>
		                    <span class="totay-5">￥<?php echo $todayorderprice_re ?></span>
		                </dd>
		                <dd>
		                    <span class="totay-1">本月</span>
		                    <span class="totay-2"><?php echo $monthordercount ?>笔</span>
		                    <span class="totay-3">￥<?php echo $monthorderprice ?></span>
		                    <span class="totay-4"><?php echo $monthordercount_re ?>笔</span>
		                    <span class="totay-5">￥<?php echo $monthorderprice_re ?></span>
		                </dd>
		                <dd>
		                    <span class="totay-1">本年</span>
		                    <span class="totay-2"><?php echo $yearordercount ?>笔</span>
		                    <span class="totay-3">￥<?php echo $yearorderprice ?></span>
		                    <span class="totay-4"><?php echo $yearordercount_re ?>笔</span>
		                    <span class="totay-5">￥<?php echo $yearorderprice_re ?></span>
		                </dd>
		            </dl>
		        </div>
		        <!--end 今日简报-->		        
		    </div>
		</div>

        <div class="panel panel-default access-amount-table">
            <!-- Default panel contents -->
            <div class="panel-heading access-amount-head">
                <ul>
                    <li class="title" >最近收支流水</li>
                </ul>
            </div>
            <!-- Table -->
            <table class="table">
                <tr>
                    <th>详情</th>
                    <th>用户账户</th>
                    <th>购买商品</th>
                    <th>发生时间</th>
                    <th>收支金额</th>
                </tr>
                <?php foreach($paylog as $one_row){ ?>
                    <tr class="access-amount-html">
                        <td><?php echo $one_row['remark']; ?></td>
                        <td><?php echo $one_row['mobile']; ?></td>
                        <td><?php echo $one_row['title']; ?></td>
                        <td><?php echo date("Y-m-d H:i:s",$one_row['createtime']); ?></td>
                        <td><?php echo $one_row['fee']; ?>
                            <?php if($one_row['check_step'] == 1){
                                echo "<span class='btn btn-info btn-xs'>等待审核</span>";
                            }else if($one_row['check_step'] == 2){
                                echo "<span class='btn btn-danger btn-xs'>审核失败</span>";
                            }else if($one_row['check_step'] == 3){
                                echo "<span class='btn btn-success btn-xs'>提现成功</span>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?php echo $pager; ?>
        </div>

    </div>
</div>
     <?php  include page('footer');?>
 <script type="text/javascript">
    function myheight(){
        var myheight1 = $(".main-wrap").height()+120;
        $("#main",window.parent.document).height(myheight1);
    }
    myheight();
    laydate({
        elem: '#begintime',
        istime: true, 
        event: 'click',
        format: 'YYYY-MM-DD hh:mm:ss',
        istoday: true, //是否显示今天
        start: laydate.now(0, 'YYYY-MM-DD hh:mm:ss')
    });
    laydate({
        elem: '#endtime',
        istime: true, 
        event: 'click',
        format: 'YYYY-MM-DD hh:mm:ss',
        istoday: true, //是否显示今天
        start: laydate.now(0, 'YYYY-MM-DD hh:mm:ss')
    });
    laydate({
        elem: '#shopbegintime',
        istime: true, 
        event: 'click',
        format: 'YYYY-MM-DD hh:mm:ss',
        istoday: true, //是否显示今天
        start: laydate.now(0, 'YYYY-MM-DD hh:mm:ss')
    });
    laydate({
        elem: '#shopendtime',
        istime: true, 
        event: 'click',
        format: 'YYYY-MM-DD hh:mm:ss',
        istoday: true, //是否显示今天
        start: laydate.now(0, 'YYYY-MM-DD hh:mm:ss')
    });
    laydate.skin("molv"); 

     </script>
     </body>
</html>