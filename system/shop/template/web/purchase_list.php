<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php  include page('header');?>
<script type="text/javascript" src="<?php echo RESOURCE_ROOT;?>/addons/common/laydate/laydate.js"></script>
<style type="text/css">

	.purchase-table-list li{
		margin:7px 5px;
		float: left;
		list-style: none;
	}
	.purchase-table-list td{
		padding: 0!important;
	}
	.add-more{
		text-align: center;
		cursor: pointer;

	}
	.hide-tr{
		display: none;
	}
	.quick-delivery .modal-dialog{
		width: 800px;
	}
	.express-area{
		text-align: left;
		padding-bottom: 17px;
	}
	.quick-delivery-btn{
		cursor: pointer;
	}
	.purchase-table-list .li-height{
	    height: 30px;
	    padding-left: 5px;
	}
	.purchase-table-list li select{
		height: 30px;
	}
	.left-span{
		float: left;
	    line-height: 28px;
	    background-color: #ededed;
	    padding: 0 5px;
	    border: 1px solid #cdcdcd;
	    border-right: 0;
	    font-size: 12px;
	}
	.modal-body .shipment_td{
		color: #2fc17f
	}
	.remark-btn-div{
		position: relative;
	}
	.remark-detail{
		display: none;
	    background: #fff;
	    border-radius: 4px;
	    padding: 15px;
	    width: 250px;
	    position: absolute;
	    top: 24px;
	    left: -42px;
	    border: 1px solid #ddd;
	    text-align: left;
	}
	.tag-remark-detail{
		display: none;
		background: #fff;
	    border-radius: 4px;
	    padding: 15px;
	    position: absolute;
	    width: 250px;
	    top: 60px;
	    right: 0;
	    border: 1px solid #ddd;
	    text-align: left;
	}
</style>
<script>
	function cleartime()
	{
	document.getElementById("begintime").value='';
	document.getElementById("endtime").value='';
	}
	</script>
	<h3 class="header smaller lighter blue">批发订单管理</h3>
	
<form action="" target="_blank">
	<input type="hidden" name="name" value="addon16" />
	<input type="hidden" name="do"  value="print" />
	<input type="hidden" name="op"  value="normal_print" />
		<input type="hidden" name="mod"  value="site" />
	
	<input type="hidden" name="print_orderid" id="print_orderid" value="" />
		<div id="modal-normalprint" class="modal  fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">快递单打印</h4>
      </div>
      <div class="modal-body">
      	
      		  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-left" > 打印模板：</label>

										<div class="col-sm-9">
														<select name="print_modle_id"  >
																	<?php  foreach($normal_order_list as $item){?>
										<option value="<?php echo $item['id'];?>" data-name=""><?php echo $item['name'];?></option>
										
													<?php } ?>
                                        </select>
										</div>
									</div>
      	
      	
      	  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-left" > </label>

										<div class="col-sm-9">
      								</div>
									</div>
      </div>
      <div class="modal-footer">
      	<button type="submit" class="btn btn-primary" name="do_normal_print" value="yes">打印</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭窗口</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
</form>

<form action="" target="_blank">
		<input type="hidden" name="name" value="addon16" />
	<input type="hidden" name="do"  value="print" />
	<input type="hidden" name="op"  value="express_print" />
			<input type="hidden" name="mod"  value="site" />
	<input type="hidden" name="print_express_orderid" id="print_express_orderid" value="" />
		<div  id="modal-expressprint"  class="modal  fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">发货单打印</h4>
      </div>
      <div class="modal-body">
      	
      		  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-left" > 打印模板：</label>

										<div class="col-sm-9">
														<select name="print_modle_id"  >
																	<?php  foreach($express_order_list as $item){?>
										<option value="<?php echo $item['id'];?>" data-name=""><?php echo $item['name'];?></option>
										
													<?php } ?>
                                        </select>
										</div>
									</div>
									
									  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-left" > </label>

										<div class="col-sm-9">
      								</div>
									</div>
      </div>
      <div class="modal-footer">
      	<button type="submit" class="btn btn-primary" name="do_normal_print" value="yes">打印</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭窗口</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
</form>
	
<form action="" method="get">

	<input type="hidden" name="mod" value="site"/>
	<input type="hidden" name="name" value="shop"/>
	<input type="hidden" name="do" value="purchase"/>
	<input type="hidden" name="op" value="display"/>
	<input type="hidden" name="status" value="<?php  echo $status;?>"/>
	<table  class="table purchase-table-list" style="width:100%;border: 1px solid #ddd;" align="center">
		<tbody>
			<tr >
				<td>
					<li>
						<span class="left-span">订单编号</span>
						<input name="ordersn" class="li-height" placeholder="订单编号" type="text" value="<?php  echo $_GP['ordersn'];?>" /> 
					</li>	
				
					

					<li>
						<?php if(isAgentAdmin()){ ?>
						<span class="left-span">业务员：</span>
							<select  id="relation_uid" name="relation_uid" >
								 <option value="" <?php  echo empty($_GP['relation_uid'])?'selected':'';?>>--选择业务员--</option>
								<?php  if(is_array($agentAdmin)) { foreach($agentAdmin as $item) { ?>
									<?php if($item["id"] == $_SESSION['account']['id']){ ?>
										<option value="<?php  echo $item["id"];?>" <?php  echo $item['id']==$_GP['relation_uid']?'selected':'';?>><?php  echo $item['username']?></option>
									<?php  } ?>
								<?php  } } ?>
						   </select>
		               	<?php } else{ ?>
		               	<span class="left-span">业务员：</span>
							<select  id="relation_uid" name="relation_uid" >
								<option value="" <?php  echo empty($_GP['relation_uid'])?'selected':'';?>>--选择业务员--</option>
								<?php  if(is_array($agentAdmin)) { foreach($agentAdmin as $item) { ?>
									<option value="<?php  echo $item["id"];?>" <?php  echo $item['id']==$_GP['relation_uid']?'selected':'';?>><?php  echo $item['username']?></option>
								<?php  } } ?>
							</select>
						<?php } ?>
					</li>
					<li >
						<span class="left-span">导出模板</span>
	                    <select name="template">
						    <option value="3" <?php  echo $_GP['template']==3?'selected':'';?>>订单核算</option>
	                        <option value="2" <?php  echo $_GP['template']==2?'selected':'';?>>彩虹快递发货</option>
							<option value="1" <?php  echo $_GP['template']==1?'selected':'';?>>平潭保税区发货</option>
						</select>
					</li>
					<li >
						<span class="left-span">标记</span>
	                    <select name="tag">
						  <option value="-1" selected>--未选择--</option>
	                      <option value="0" <?php  echo $_GP['tag']==0?'selected':'';?>>灰色</option>
						  <option value="1" <?php  echo $_GP['tag']==1?'selected':'';?>>红色</option>
						  <option value="2" <?php  echo $_GP['tag']==2?'selected':'';?>>黄色</option>
						  <option value="3" <?php  echo $_GP['tag']==3?'selected':'';?>>绿色</option>
						  <option value="4" <?php  echo $_GP['tag']==4?'selected':'';?>>蓝色</option>
						  <option value="5" <?php  echo $_GP['tag']==5?'selected':'';?>>紫色</option>
					  	</select>			
					</li>	
					<li>
						<span class="left-span">起始日期</span>
						<input class="li-height" placeholder="起始日期" name="begintime" id="begintime" type="text" value="<?php  echo $_GP['begintime'];?>" readonly="readonly"  />
					</li>
					<li> - </li>
					<li>
						<span class="left-span">终止日期</span>
						<input class="li-height" placeholder="终止日期" id="endtime" name="endtime" type="text" value="<?php  echo $_GP['endtime'];?>" readonly="readonly"  /> <a href="javascript:;" onclick="cleartime()">清空</a>
			
						<script type="text/javascript">
							laydate({
						        elem: '#begintime',
						        istime: true, 
						        event: 'click',
						        format: 'YYYY-MM-DD hh:mm:ss',
						        istoday: true, //是否显示今天
						        start: laydate.now(0, 'YYYY-MM-DD hh:mm:ss')
						    });
						    laydate.skin("molv"); 
						</script> 
						<script type="text/javascript">
							laydate({
						        elem: '#endtime',
						        istime: true, 
						        event: 'click',
						        format: 'YYYY-MM-DD hh:mm:ss',
						        istoday: true, //是否显示今天
						        start: laydate.now(0, 'YYYY-MM-DD hh:mm:ss')
						    });
						    laydate.skin("molv"); 
						</script>
					</li>		
					<li >
						<button type="submit" name="report" value="report"  class="btn btn-warning btn-sm">导出excel</button>
						<a  href="<?php echo $_SERVER['REQUEST_URI'] ?>&print=print" target="_blank" class="btn btn-info btn-sm">打印订单</a>
						<div class="btn-group">
						  <input type="submit" name="submit" value=" 查 询 "  class="btn btn-primary btn-sm">
						  <button type="button" class="btn btn-primary btn-sm dropdown-toggle add-more-btn" data-toggle="dropdown">
						    <span class="caret"></span>
						    <span class="sr-only">Toggle Dropdown</span>
						  </button>
						</div>
					</li>
					
				</td>
			</tr>
			<tr class="hide-tr">
				<td>
					<li >
						<span class="left-span">收货人手机</span>
						<input name="address_mobile" class="li-height" placeholder="收货人手机" type="text" value="<?php  echo $_GP['address_mobile'];?>" />
					</li>
					<li><span class="left-span">产品名称</span><input name="goodsname" class="li-height" placeholder="产品名称" type="text" value="<?php  echo $_GP['title'];?>" /></li>
					<li >
						<span class="left-span">收货人姓名</span>
						<input  class="li-height" placeholder="收货人姓名" name="address_realname" type="text" value="<?php  echo $_GP['address_realname'];?>" />
					</li>

					
					

					
				</td>
			</tr>
		</tbody>
	</table>
</form>
			
			
<h3 class="blue">	<span style="font-size:18px;"><strong>订单总数：<?php echo $total ?></strong></span></h3>
			<ul class="nav nav-tabs" >
	<li style="width:7%" <?php  if($status == -110) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => -110))?>">我方承运</a></li>
	<li style="width:7%" <?php  if($status == -100) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => -100))?>">自提订单</a></li>
	<li style="width:7%" <?php  if($status == -99) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => -99))?>">全部</a></li>
	<li style="width:7%" <?php  if($status == 0) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => 0))?>">待付款</a></li>
	<li style="width:7%" <?php  if($status == 1) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => 1))?>">待发货</a></li>
	<li style="width:7%" <?php  if($status == 2) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => 2))?>">待收货</a></li>
	<li style="width:7%" <?php  if($status == 3) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => 3))?>">已完成</a></li>
	<li style="width:7%" <?php  if($status == -1) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => -1))?>">已关闭</a></li>
		<li style="width:7%" <?php  if($status == -2) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => -2))?>">退款中</a></li>
		<li style="width:7%" <?php  if($status == -4) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => -4))?>">退货中</a></li>
		<li style="width:7%" <?php  if($status == 34) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => 34))?>">退款完成</a></li>
		<li style="width:7%" <?php  if($status == 14) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => 14))?>">退货完成</a></li>
		<li style="width:7%" <?php  if($status == -321) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => -321))?>">退款关闭</a></li>
		<li style="width:7%" <?php  if($status == -121) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'purchase','op' => 'display', 'status' => -121))?>">退货关闭</a></li>
			</ul>
		

<table class="table  table-bordered table-hover">
			<thead >
				<tr>
				    <th style="width:400px;text-align:center;">宝贝</th>
					<th style="width:80px;text-align:center;">单价</th>
					<th style="width:80px;text-align:center;">数量</th>
					
					<th style="width:100px;text-align:center;">售后状态</th>
					<th style="width:50px;text-align:center;">买家</th>
					<th style="width:150px;text-align:center;">下单时间</th>
					<th style="width:80px;text-align:center;">业务员</th>
					<th style="width:120px;text-align:center;" >订单状态</th>
					<th style="width:150px;text-align:center;">实收款</th>     
					<th style="width:50px;text-align:center;">标记</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr><td align="left" colspan="10" style="background:#E9F8FF;margin-top:10px;"><?php  echo $item['ordersn'];?>&nbsp;&nbsp;</td></tr>
				<tr class="order_info">
				    <td  colspan="4">
					<?php 
					    if ( is_array($item['goods']) ){
							  $j = 0;
							  $count_num = count($item['goods']);
                               foreach ( $item['goods'] as $goods ){  $j++;
					?>
					    <div class="items">
						      <ul>
							      <li class="img"><a target="_blank" href="<?php  echo mobile_url('detail', array('name'=>'shopwap','id' => $goods['aid']))?>"><img src="<?php echo getGoodsThumb($goods['gid']); ?>" height="40" /></a></li>
								  <li class="title"><div><a target="_blank" href="<?php  echo mobile_url('detail', array('name'=>'shopwap','id' => $goods['aid']))?>" class="tab_title"><?php echo $goods['title']; ?></a></div>
									  <div>
										  <div class="name"><?php echo getGoodsProductPlace($goods['pcate']); ?></div>
										  &nbsp;&nbsp;&nbsp;<span style="padding: 0 3px; border: 1px solid #fe3d53;color: #fe3d53;font-size: 10px;display:inline-block;"><?php  echo getGoodsCategory($goods['p1']);?></span>
										  &nbsp;&nbsp; <span class="label label-success"><?php echo getGoodsType($goods['shop_type']); ?></span> &nbsp;&nbsp; <span class="label label-success"><?php echo $goods['expresssn']!=''?'该产品已发货':''; ?></span>
									  </div>
									  <div class="sn">商家编码: <?php echo $goods['goodssn']; ?></div>
								  </li>
								  <li class="price"><?php echo $goods['orderprice']; ?></li>
								  <li class="tot"><?php echo $goods['total']; ?></li>
								  <li class="tot">
									  <span class="shouhou_status">
								   <?php
								   		if($goods['order_type'] == 1 && $goods['order_status'] == 1)  echo getOrderAfterSlaseUrl("退货申请中",$goods['order_id'],$item['id'],'good');
								   		if($goods['order_type'] == 1 && $goods['order_status'] == 2)  echo getOrderAfterSlaseUrl("<b>退货审核通过</b>",$goods['order_id'],$item['id'],'good');
								   		if($goods['order_type'] == 1 && $goods['order_status'] == 3)  echo getOrderAfterSlaseUrl("买家发货中",$goods['order_id'],$item['id'],'good');
								   		if($goods['order_type'] == 1 && $goods['order_status'] == 4)  echo getOrderAfterSlaseUrl("退货成功",$goods['order_id'],$item['id'],'good');
								   		if($goods['order_type'] == 1 && $goods['order_status'] == -1)  echo getOrderAfterSlaseUrl("退货审核驳回",$goods['order_id'],$item['id'],'good');
								   		if($goods['order_type'] == 1 && $goods['order_status'] == -2)  echo getOrderAfterSlaseUrl("买家撤销退货",$goods['order_id'],$item['id'],'good');
									   if($goods['order_type'] == 3 && $goods['order_status'] == 1)  echo getOrderAfterSlaseUrl("退款申请中",$goods['order_id'],$item['id'],'money');
									   if($goods['order_type'] == 3 && $goods['order_status'] == 2)  echo getOrderAfterSlaseUrl("<b>退款审核通过</b>",$goods['order_id'],$item['id'],'money');
									   if($goods['order_type'] == 3 && $goods['order_status'] == 4)  echo getOrderAfterSlaseUrl("退款成功",$goods['order_id'],$item['id'],'money');
									   if($goods['order_type'] == 3 && $goods['order_status'] == -1)  echo getOrderAfterSlaseUrl("退款审核驳回",$goods['order_id'],$item['id'],'money');
									   if($goods['order_type'] == 3 && $goods['order_status'] == -2)  echo getOrderAfterSlaseUrl("买家撤销退款",$goods['order_id'],$item['id'],'money');

								   ?>
										  </span>
								   </li>
							  </ul>
						</div>
					<?php
							   }
					    }?>
						
					</td>
			       
					<td align="center" valign="middle" style="vertical-align: middle;">
				       <div>收货人：<?php  echo $item['address_realname'];?></div>
					   <div>电话：<?php  echo $item['address_mobile'];?></div>
					   <div>地址:<?php  echo $item['address_province'];?><?php  echo $item['address_city'];?><?php  echo $item['address_area'];?><?php  echo $item['address_address'];?></div>
					   <?php if ( !empty($item['remark'])){ ?>
					   <div class="remark-btn-div">
					   		<a class="remark-modal" type="button" href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="<?php echo $item['remark']; ?>">
					   			<img src="images/tag.png" />
					   		</a>
					   		<div class='remark-detail'>  
								<?php echo $item['remark']; ?>
							</div>
					   	</div>
					   
					   <?php } ?>
					</td>
					<td align="center" valign="middle" style="vertical-align: middle;"><?php  echo date('Y-m-d H:i:s', $item['createtime'])?></td>
		           <td align="center" valign="middle" style="vertical-align: middle;">
						<?php  echo getAdminName($item['relation_uid']);?>
						<?php
						if(!empty($item['retag'])){
							$retag = json_decode($item['retag'],true);
							if(!empty($retag['recoder'])){
								echo "<input type='hidden' value='{$item['retag']}' class='hide_order_log'/>";
								echo "<span style='display:block;font-weight: bolder;color: #00D20D;cursor: pointer'><span class='glyphicon glyphicon-comment show_order_log'></span></span>";
							}
						}
						?>
					</td>
					<td align="center" valign="middle" style="vertical-align: middle;">
					    <div>
					     <?php  if($item['status'] == 0) { ?><span class="label label-warning" >待付款</span><?php  } ?>
                        <?php if(isHasPowerToShow('shop','purchase','express') && $item['status'] == 1){ ?>
						    <span class="label label-warning quick-delivery-btn" style="margin-left:3px;background-color:#4edbf0">快捷发货</span>
					     	<div class="modal fade quick-delivery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">

									  	<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
											<h4 class="modal-title" id="myModalLabel">快捷配送</h4>
									  	</div>
									  	<div class="modal-body">
										  		<input type="hidden" name="order_id" class="order_id" value="<?php  echo $item['id'];?>">
										  		<div class="express-area">
										  			<span>快递公司</span>
										  			<select onchange="onchangcheckbox();" name="express" class="express">
														<option value="-1" >请选择</option>
														<?php   foreach($dispatchlist as $dispatchitem) { ?>
														<option value="<?php echo $dispatchitem['code'];?>" data-name="<?php echo $dispatchitem['name'];?>"><?php echo $dispatchitem['name'];?></option>
														<?php   } ?>
													</select>
													<input type='hidden'  name='expresscom' class='expresscom'  />
													<span>快递单号</span>
													<input type="text"  name="expressno"  class="expressno" placeholder="请输入快递单号"  value="">
													<div class="btn btn-primary btn-sm ships-search" onclick="return checkVal(this)">设 置</div>
										  		</div>
											 	<table class="table table-striped table-bordered table-hover">
											 		<tr>
											 			<th><input type="checkbox" class="check_all"></th>
												 		<th>图片</th>
												 		<th>产品名称</th>
												 		<th>快递公司</th>
												 		<th>快递单号</th>
												 	</tr>
												 	<?php 
													    if ( is_array($item['goods']) ){
															  $count_num = count($item['goods']);
								                               foreach ( $item['goods'] as $goods ){
													?>
											 		<tr>
											 			<td class="shipment_td"><?php if ( empty($goods['expresssn']) ){ ?><input type="checkbox" class="shipment_checkbox shipment_<?php  echo $goods['aid'];?>" name="shipment[]" value="<?php  echo $goods['aid'];?>"><?php }else{ ?> <i class="icon-ok"></i><?php } ?></td>
												 		<td><img src="<?php echo getGoodsThumb($goods['gid']); ?>" height="40" /></td>
												 		<td><?php echo $goods['title']; ?></td>
												 		<td class="expresscom-td">
												 			 <?php echo $goods['expresscom']; ?>
												 		</td>
												 		<td class="expresssn" >
												 			  <?php echo $goods['expresssn']; ?>
												 		</td>
												 	</tr>
												 	<?php
														   }
												    }?>
											 	</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default express-close" data-dismiss="modal">关闭</button>
										</div>
									</div>
								</div>
						    </div>
							<?php } ?>
							<!--已经付钱的，团购中 或者团购未开奖 这叫做已支付，因为不在待发货中展示，其他的叫待发货-->
							<?php  if($item['status'] == 1) {
								if(checkGroupBuyCanSend($item)){
									echo '<span class="label label-danger" >待发货</span>';
								}else{
									echo '<span class="label label-danger" >已支付</span>';
								}

							}
							?>
						<?php  if($item['status'] == 2) { ?><span class="label label-warning">待收货</span><?php  } ?>
						<?php  if($item['status'] == 3) { ?><span class="label label-success" >已完成</span><?php  } ?>
						<?php  if($item['status'] == -1) { ?><span class="label label-success">已关闭</span><?php  } ?>
						<?php  if($item['status'] == -2) { ?><span class="label label-danger">退款中</span><?php  } ?>
						<?php  if($item['status'] == -3) { ?><span class="label label-danger">换货中</span><?php  } ?>
						<?php  if($item['status'] == -4) { ?><span class="label label-danger">退货中</span><?php  } ?>
						<?php  if($item['status'] == -5) { ?><span class="label label-success">已退货</span><?php  } ?>
						<?php  if($item['status'] == -6) { ?><span class="label  label-success">已退款</span><?php  } ?>
						</div>
						<div><a  href="<?php  echo web_url('order', array('op' => 'detail', 'id' => $item['id']))?>"><i class="icon-edit"></i>查看详情</a></div>
						<div><a  href="<?php  echo web_url('order', array('op' => 'identity', 'id' => $item['id']))?>"><i class="icon-edit"></i>查看清关材料</a></div>
						<?php  if($hasaddon11) { ?>
						&nbsp;<a class="btn btn-xs btn-info"  href="<?php  echo create_url('site',array('name' => 'addon11','do' => 'orderPrint','orderid' =>$item['id']))?>"><i class="icon-print"></i>小票打印</a>
						<?php  } ?>
					<?php  if($hasaddon16) { ?>
						&nbsp;<a class="btn btn-xs btn-info"   onclick="document.getElementById('print_orderid').value='<?php  echo $item['id']?>';$('#modal-normalprint').modal()" href="javascript:;">发货单打印</a>
						&nbsp;
						<a  class="btn btn-xs btn-info"  onclick="document.getElementById('print_express_orderid').value='<?php  echo $item['id']?>';$('#modal-expressprint').modal()" href="javascript:;">快递单打印</a>
					<?php  } ?>
				&nbsp;&nbsp;
						</td>
						<td align="center" valign="middle" style="vertical-align: middle;">
							<div><?php  echo $item['price'];?> 元 </div><?php  if($item['hasbonus']>0) { ?><div class="label label-success">惠<?php echo $item['bonusprice'];?></div><?php  }?><div style="font-size:10px;color:#999;">(含运费:<?php  echo $item['dispatchprice'];?> 元)</div><div style="font-size:10px;color:#999;">(含进口税:<?php  echo $item['taxprice'];?> 元)</div>
						</td>
						<td align="center" valign="middle" style="vertical-align: middle;">
							<div style="position:relative">
								<a class="tag-remark" type="button" href="<?php  echo web_url('order', array('op' => 'detail', 'id' => $item['id']))?>" ><img src="images/btag<?php echo $item['tag']; ?>.png" /></a>
								<div class="tag-remark-detail">
									<?php if(!empty($item['retag'])){ $retag_json = json_decode($item['retag'],true); echo $retag_json['beizhu'];}else{ echo '没有标注信息'; } ?>
								</div>
							</div>
						</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>

		<!-- 订单日志弹出框 -->
		<div class="modal fade" id="orderLogModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">订单操作日志</h4>
					</div>
					<div class="modal-body">
						<p class="modal_ordersn"></p>
						<p class="modal_title"></p>
						<table class="table">
							<thead>
							<tr>
								<th>管理员</th>
								<th>操作信息</th>
								<th>时间</th>
							</tr>
							</thead>
							<tbody class="modal_order_log">

							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal -->
		</div>

		<script type="text/javascript">
		var delivery_num = 0;
			$(function(){
				
				$(".quick-delivery-btn").click(function(){
					$(this).siblings(".quick-delivery").modal();
					delivery_num = 0;
				});
				$(".add-more-btn").click(function(){
					$(".hide-tr").toggle();
				});
				$(".check_all").click(function(){
	            	var checked = $(this).get(0).checked;
	                $("input[type=checkbox]").prop("checked", checked);
	                    
	            });
	            $(".remark-modal").click(function(){
					$(this).siblings(".remark-detail").toggle();
				})
				$(".tag-remark").hover(function(){
					$(this).siblings(".tag-remark-detail").show();
				},function(){
					$(this).siblings(".tag-remark-detail").hide();
				})
			});
			function checkVal(obj){
				var express_val = $(obj).siblings(".express").val();
				var expressno_val = $(obj).siblings(".expressno").val();
				var check_num = 0;
				var shipment_checkbox = $(obj).parents(".express-area").siblings("table").find(".shipment_checkbox");
				var order_id = $(".order_id").val();
				var expresscom = $(obj).siblings(".expresscom").val();
				var shipment_checkbox_val = [];
				shipment_checkbox.each(function(idnex,element){
					if($(element).get(0).checked){
						check_num++;
						shipment_checkbox_val.push($(element).val());
					}
				});
				if( shipment_checkbox.length == 0 ){
					check_num = 0;
				}
				if( express_val== -1 ){
					alert("请选择快递公司");
					return false;
				}
				if( expressno_val=="" ){
					alert("请输入快递单号");
					return false;
				}
				if( check_num==0 ){
					alert("请选择配送商品");
					return false;
				}
				$(".sub-sure").click(function(){
					$('.quick-delivery').modal('hide')
				});
				$(obj).parents(".modal-body").siblings(".modal-footer").find(".express-close").on("click",function(){
					if( delivery_num >= 1){
						window.location.reload();
					}
				})
				$.post("",{express:express_val,expressno:expressno_val,shipment:shipment_checkbox_val,order_id:order_id,expresscom:expresscom},function(data){
					if( data.errno == 200 ){
						delivery_num++;
						var data_result = data.message
						for( var i = 0; i < data_result.shipment.length ; i++ ){
							$(".shipment_"+data_result.shipment[i]+"").parent("td").siblings(".expresscom-td").text(data_result.express);
							$(".shipment_"+data_result.shipment[i]+"").parent("td").siblings(".expresssn").html(data_result.expresssn);
							$(".shipment_"+data_result.shipment[i]+"").parent("td").html("<i class='icon-ok'></i>");	
						}
						alert("快捷发货成功");
					}else{
						alert(data.message);
					}
				},'json')
			}
			
		</script>
		<?php  echo $pager;?>
<script>
	function onchangcheckbox()
	{
            var obj = $(".express");  
            var sel =obj.find("option:selected").attr("data-name");
            $(".expresscom").val(sel);
	}

	//点击查看订单日志
	$(".show_order_log").click(function(){
		var log_string = $(this).parent().prev().val();
		log_obj  = JSON.parse(log_string);
		//格式 2-测试订单-54815154545;3-已经发货-2323423  分号分开的字符串
		log_info = log_obj.recoder;
		//弹出框
		$("#orderLogModal").modal();

		var ordersn = '订单号：'+ $(this).closest('.order_info').prev().find('td').html();
		var tit     = $(this).closest('.order_info').find('.tab_title').html();
		$("#orderLogModal .modal_ordersn").html(ordersn);
		$("#orderLogModal .modal_title").html(tit);

		var log_info = log_info.split(";"); //字符串截取，成为数组
		var log_html = "";
		for(var i=0; i<log_info.length;i++){
			log_html += '<tr>';
			var one_log     = log_info[i];
			//["2", "测试订单", "54815154545"]
			var one_log_arr =  one_log.split("-");
			var url = "<?php echo web_url('order',array('op'=>'getAdminName')); ?>";
			url += "&uid="+one_log_arr[0];
			//这里必须用ajax的 async false同步进行，不能改用$.get或者$.post异步进行。会导致还没拼接完，进入下一个循环
			$.ajax({
				url:url,
				type: "POST",
				async: false,
				dataType:'json',
				success:function(data,xml){
					var admin   = data.message;
					var message =  one_log_arr[1];
					var time    =  string_to_time(one_log_arr[2]);

					log_html   += "<td>"+ admin +"</td>";
					log_html   += "<td>"+ message +"</td>";
					log_html   += "<td>"+ time +"</td>";
					log_html += '</tr>';
				}
			});
		}

		$("#orderLogModal .modal_order_log").html(log_html);
	})

	function string_to_time(time){
		var datetime = new Date();
		datetime.setTime(time*1000);
		var year = datetime.getFullYear();
		var month = datetime.getMonth() + 1 < 10 ? "0" + (datetime.getMonth() + 1) : datetime.getMonth() + 1;
		var date = datetime.getDate() < 10 ? "0" + datetime.getDate() : datetime.getDate();
		var hour = datetime.getHours()< 10 ? "0" + datetime.getHours() : datetime.getHours();
		var minute = datetime.getMinutes()< 10 ? "0" + datetime.getMinutes() : datetime.getMinutes();
		var second = datetime.getSeconds()< 10 ? "0" + datetime.getSeconds() : datetime.getSeconds();
		return year + "-" + month + "-" + date+" "+hour+":"+minute+":"+second;
	}

</script>
<?php  include page('footer');?>