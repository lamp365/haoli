<?php defined('SYSTEM_IN') or exit('Access Denied');?><?php  include page('header');?>
<style>
	.nav-tabs li a{
		padding: 6px 22px;
	}
</style>
<br/>
<ul class="nav nav-tabs" >
	<li style="" <?php  if($_GP['do'] == 'disharea') { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'disharea','op' => 'display'))?>">运费管理</a></li>
	<li style="" <?php  if($_GP['do'] == 'promotion')  { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'promotion','do'=>'promotion','op' => 'display'))?>">促销免邮</a></li>
	<li style="" <?php  if($_GP['do'] == 'address')  { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site',  array('name' => 'shop','do'=>'address','op' => 'index'))?>">退货地址</a></li>
</ul>
<h3 class="header smaller lighter blue">促销免运费&nbsp;&nbsp;&nbsp;
	<?php if(empty($pormotions)){ ?>
	<a href="<?php  echo web_url('promotion', array('name'=>'promotion','op'=>'post'));?>" class="btn btn-primary">添加促销免运费</a>
	<?php } ?>
</h3>
<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
			<th class="text-center" >ID</th>
		 <th class="text-center" >名称</th>
    <th class="text-center"  >类型</th>
	<th class="text-center">适用平台</th>
    <th class="text-center">开始时间</th>
    <th class="text-center" >结束时间</th>
    <th class="text-center" >满足条件</th>
    <th class="text-center">操作</th>
				</tr>
			</thead>
		<?php $index=0; if(is_array($pormotions)) { $index=$index+1; foreach($pormotions as $item) { ?>
				<tr>
					<td class="text-center"><?php echo $index; ?></td>
					<td class="text-center"><?php echo $item['pname']; ?></td>
          <td class="text-center"><?php echo empty($item['promoteType'])?'按订单数包邮':'满额包邮'; ?></td>
		  <td class="text-center"><?php echo $item['type']==0?'商城':'代发'; ?></td>
           <td class="text-center"><?php echo date('Y-m-d H:i', $item['starttime']); ?></td>
          <td class="text-center"><?php echo date('Y-m-d H:i', $item['endtime']); ?></td>
          <td class="text-center">
          	<?php if($item['promoteType']==0){ ?>满<span style="color:#FF0000"><?php echo $item['condition'];?></span>件免运费<?php  }else{ ?>满<span style="color:#FF0000"><?php echo  $item['condition'];?></span>元免运费 <?php  } ?>

          	</td>
         <td class="text-center">
                    	                    	<a class="btn btn-xs btn-info"  href="<?php  echo create_url('site', array('name' => 'promotion','do' => 'promotion','op'=>'post','id'=>$item['id']))?>"><i class="icon-edit"></i>&nbsp;修&nbsp;改&nbsp;</a> 
                    	&nbsp;&nbsp;	<a class="btn btn-xs btn-info" onclick="return confirm('此操作不可恢复，确认删除？');return false;"  href="<?php  echo create_url('site', array('name' => 'promotion','do' => 'promotion','op'=>'delete','id'=>$item['id']))?>"><i class="icon-edit"></i>&nbsp;删&nbsp;除&nbsp;</a> </td>
                                </td>
				</tr>
				<?php  } } ?>
		</table>

<?php  include page('footer');?>
								