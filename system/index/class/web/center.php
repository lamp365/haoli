<?php
// +----------------------------------------------------------------------
// | WE CAN DO IT JUST FREE
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.squdian.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 小物社区 <QQ:119006873> <http://www.squdian.com>
// +----------------------------------------------------------------------
		$nowyear=intval(date('Y',time()));
		$nowmonth=intval(date('m',time()));
		$nowdate=intval(date('d',time()));
		$lastmonthday=date('t',strtotime($nowyear."-".$nowmonth."-1"));
		$lastyearday=date('t',strtotime($nowyear."-12-1"));	
		$todayordercount = mysqld_selectcolumn("SELECT count(id) FROM " . table('shop_order') . " WHERE status>=1 and createtime >=".strtotime($nowyear."-".$nowmonth."-".$nowdate." 00:00:01")." and createtime <=".strtotime($nowyear."-".$nowmonth."-".$nowdate." 23:59:59"));
		$todayorderprice = mysqld_selectcolumn("SELECT sum(price) FROM " . table('shop_order') . " WHERE status>=1 and createtime >=".strtotime($nowyear."-".$nowmonth."-".$nowdate." 00:00:01")." and createtime <=".strtotime($nowyear."-".$nowmonth."-".$nowdate." 23:59:59"));
		$monthordercount = mysqld_selectcolumn("SELECT count(id) FROM " . table('shop_order') . " WHERE status>=1 and createtime >=".strtotime($nowyear."-".$nowmonth."-01 00:00:01")." and createtime <=".strtotime($nowyear."-".$nowmonth."-".$lastmonthday." 23:59:59"));
		$monthorderprice = mysqld_selectcolumn("SELECT sum(price) FROM " . table('shop_order') . " WHERE status>=1 and createtime >=".strtotime($nowyear."-".$nowmonth."-01 00:00:01")." and createtime <=".strtotime($nowyear."-".$nowmonth."-".$lastmonthday." 23:59:59"));
		$yearordercount = mysqld_selectcolumn("SELECT count(id) FROM " . table('shop_order') . " WHERE status>=1 and createtime >=".strtotime($nowyear."-01-01 00:00:01")." and createtime <=".strtotime($nowyear."-12-".$lastyearday." 23:59:59"));
		$yearorderprice = mysqld_selectcolumn("SELECT sum(price) FROM " . table('shop_order') . " WHERE status>=1 and createtime >=".strtotime($nowyear."-01-01 00:00:01")." and createtime <=".strtotime($nowyear."-12-".$lastyearday." 23:59:59"));
        //今天的订单金额
        $timestar = strtotime($nowyear."-".$nowmonth."-".$nowdate." 00:00:01");
		$timeend = $timestar;
		$today_arr = array();
        for($today = 1; $today <= 4; $today++){
			  $time_star = $timeend;
              $time_end = $timestar + $today * 6 * 60 * 60; 
			  $order_price = mysqld_selectcolumn("SELECT sum(price) as price FROM ".table('shop_order')." WHERE status >= 1 and createtime >=".$time_star." and createtime <".$time_end);
			  $timeend =  $time_end;
			  $today_arr[$today] = $order_price > 0 ? $order_price : 0 ;
		}
		//昨天的订单金额
        $yestar = strtotime("-1 day 00:00:01");
        $yeend = $yestar;
        $yes_arr = array();
		for($today = 1; $today <= 4; $today++){
			  $time_star = $yeend;
              $time_end = $yestar + $today * 6 * 60 * 60; 
			  $order_price = mysqld_selectcolumn("SELECT sum(price) as price FROM ".table('shop_order')." WHERE status >= 1 and createtime >=".$time_star." and createtime <".$time_end);
			  $yeend = $time_end;
			  $yes_arr[$today] = $order_price > 0 ? $order_price : 0;
		}
		//分组订单金额
		$orderpricegroup = "SELECT source,count(source) as peopler, sum(price) as price FROM ".table('shop_order')." where status >= 1 group by source ";
		$ordergroup = mysqld_selectall($orderpricegroup);
		$group_list = array();
		$all_order_price = 0;




		//退货单  退货加退款 已经成功的
		$today_time         = "g.createtime >=".strtotime($nowyear."-".$nowmonth."-".$nowdate." 00:00:01")." and g.createtime <=".strtotime($nowyear."-".$nowmonth."-".$nowdate." 23:59:59");
		$todayordercount_re = mysqld_selectcolumn("SELECT count(id) FROM " . table('shop_order_goods') . " as g WHERE g.status=4  and {$today_time}");
		$sql = "SELECT SUM(price+taxprice)  FROM ".table('shop_order_goods')." AS g  WHERE g.type =4 AND {$today_time}";
		$todayorderprice_re = mysqld_selectcolumn($sql);

		$month_time = "g.createtime >=".strtotime($nowyear."-".$nowmonth."-01 00:00:01")." and g.createtime <=".strtotime($nowyear."-".$nowmonth."-".$lastmonthday." 23:59:59");
		$monthordercount_re = mysqld_selectcolumn("SELECT count(id) FROM " . table('shop_order_goods') . " as g WHERE g.status=4  and {$month_time}");
		$sql = "SELECT SUM(price+taxprice)  FROM ".table('shop_order_goods')." AS g WHERE g.type =4 AND {$month_time}";
		$monthorderprice_re = mysqld_selectcolumn($sql);

		$year_time = "g.createtime >=".strtotime($nowyear."-01-01 00:00:01")." and g.createtime <=".strtotime($nowyear."-12-".$lastyearday." 23:59:59");
		$yearordercount_re = mysqld_selectcolumn("SELECT count(id) FROM " . table('shop_order_goods') . " as g WHERE g.status=4 and {$year_time}");
		$sql = "SELECT SUM(price+taxprice) FROM ".table('shop_order_goods')." AS g  WHERE g.type =4 AND {$year_time}";
		$yearorderprice_re = mysqld_selectcolumn($sql);
		$needsend_count = mysqld_selectcolumn("SELECT count(id) FROM " . table('shop_order') . " WHERE status=1 ");
		$needsend__price = mysqld_selectcolumn("SELECT sum(price) FROM " . table('shop_order') . " WHERE status=1 ");
		//退货单
		$returnofgoods_count = mysqld_selectcolumn("SELECT count(id) FROM " . table('shop_order_goods') . " WHERE type =1 and status in (1,2,3) ");
		$sql = "SELECT SUM(price+taxprice) FROM ".table('shop_order_goods')." AS g  WHERE g.type =1 AND g.status IN (1,2,3)";
		$returnofgoods_price = mysqld_selectcolumn($sql);
		//退款单
		$returnofmoney_count = mysqld_selectcolumn("SELECT count(id) FROM " . table('shop_order_goods') . " WHERE type = 3 and status in (1,2,3) ");
		$sql = "SELECT SUM(price+taxprice) FROM  ".table('shop_order_goods')." AS g WHERE g.type =3 AND g.status IN (1,2,3)";
		$returnofmoney_price = mysqld_selectcolumn($sql);
        if(empty($returnofmoney_price)){
      		$returnofmoney_price="0.00";
      	}else
      	{
      	$returnofmoney_price=round($returnofmoney_price,2);	
      	}
      	 	if(empty($needsend__price))
      	{
      		$needsend__price="0.00";
      	}else
      	{
      	$needsend__price=round($needsend__price,2);	
      	}
      	 	if(empty($returnofgoods_price))
      	{
      		$returnofgoods_price="0.00";
      	}else
      	{
      	$returnofgoods_price=round($returnofgoods_price,2);	
      	}
      	
      	if(empty($todayorderprice))
      	{
      		$todayorderprice="0.00";
      	}else
      	{
      	$todayorderprice=round($todayorderprice,2);	
      	}
      		if(empty($monthorderprice))
      	{
      		$monthorderprice="0.00";
      	}else
      	{
      	$monthorderprice=round($monthorderprice,2);	
      	}
      		if(empty($yearorderprice))
      	{
      		$yearorderprice="0.00";
      	}else
      	{
      	$yearorderprice=round($yearorderprice,2);	
      	}
      	    	if(empty($todayorderprice_re))
      	{
      		$todayorderprice_re="0.00";
      	}else
      	{
      	$todayorderprice_re=round($todayorderprice_re,2);	
      	}
      		if(empty($monthorderprice_re))
      	{
      		$monthorderprice_re="0.00";
      	}else
      	{
      	$monthorderprice_re=round($monthorderprice_re,2);	
      	}
      		if(empty($yearorderprice_re))
      	{
      		$yearorderprice_re="0.00";
      	}else
      	{
      	$yearorderprice_re=round($yearorderprice_re,2);	
      	}

//最近收支流水
$money_list = array();
$pindex = max(1, intval($_GP['page']));
$psize  = 20;//默认每页10条数据
$limit  = ' limit '.($pindex-1)*$psize.','.$psize;
$where  = "type !='usecredit' and type != 'addcredit'";
$paylog = mysqld_selectall("select * from ".table('member_paylog')." where {$where} order by pid desc {$limit}");
if(empty($paylog)){
	$total  = 0;
}else{
	$total  = mysqld_selectcolumn("select count('pid') from ".table('member_paylog')." where {$where}");
}

foreach($paylog as $key => &$one){
	$mem = member_get($one['openid'],'mobile,nickname');
	$paylog[$key]['mobile']   = $mem['mobile'];
	$paylog[$key]['nickname'] = $mem['nickname'];
	if(empty($one['orderid']))
		$dish['title'] = '';
	else
		$dish = mysqld_select("select d.title from ".table('shop_order_goods')." as g left join ".table('shop_dish')." as d on d.id=g.goodsid where g.orderid={$one['orderid']}");
	$paylog[$key]['title']  = $dish['title'];
}
$pager = pagination($total, $pindex, $psize);

//总收入
$sys_money = mysqld_select("select * from ".table('shop_money'));
//本月技术提成
$seting     = globaSetting();
$service    = new \service\shop\outgoldService();
$jishuMoney = $service->jishuMoney($seting['jishu_rate']);
include page('center');