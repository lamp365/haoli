<?php defined('SYSTEM_IN') or exit('Access Denied');?><?php  include page('header');?>

<script type="text/javascript" src="<?php echo RESOURCE_ROOT;?>/addons/common/js/jquery-ui-1.10.3.min.js"></script>
<style type="text/css">
	.icon-pencil{
		padding: 0 8px;
		cursor: pointer;
	}
	td{
		position: relative;
	}
	.modify-input{
		position: absolute;
		width: 100%;
    	left: 0;
    	display: none;
	}
	.no-padding-left{
		line-height: 34px;
   		text-align: right;
	}
	.modal-title{
		text-align: center;
	}
	.form-group{
		overflow: hidden;
	}
	.wholesale-cogs{font-size: 16px;}
	.product-stock span,.wholesale-cogs{
		cursor: pointer;
	}
	.modal-content{
		margin-top: 300px;
	}
	.wholesale-td{
		position: relative;
	}
	.vip-form-desc{
		text-align: left;
	    margin: 0 auto;
	    border-bottom: 1px dotted #ddd;
	    margin-bottom: 15px;
	    padding-bottom: 15px;
	}
	.shop-list-tr{
		background-color: #fff!important;
	}
	.shop-list-tr li{
		float:left;list-style-type:none;
	}
	.shop-list-tr select{
		margin-right:10px;height:30px; line-height:28px; padding:2px 0;
	}
	#dLabel{
		cursor: pointer;
		padding-right: 15px;
	}
	.wholesale-price{
		color: #d22046;
    	font-weight: bold;
	}
	.wholesale-div li{
		padding: 5px 0 5px 10px;
	}
	.nav-tabs li a{
		padding: 6px 22px;
	}
</style>
<br/>
<ul class="nav nav-tabs" >
	<li style="" <?php  if($is_used == 0) { ?> class="active"<?php  } ?>><a href="<?php  echo web_url('dish',  array('op' => 'show_number', 'is_used' => 0))?>">未使用</a></li>
	<li style="" <?php  if($is_used == 1) { ?> class="active"<?php  } ?>><a href="<?php  echo web_url('dish',  array('op' => 'show_number', 'is_used' => 1))?>">已使用</a></li>
</ul>

<table class="table table-striped table-bordered table-hover">
		<tbody>
		<tr class="shop-list-tr">
			<td>
				<li>
					<select  class="get_category" onchange="getNumberByDish(this)" style="margin-right:10px;width: 350px; height:30px; line-height:28px; padding:2px 0">
						<option value="0">查看所有</option>
						<?php foreach($allDish as $the_dish){
							$sel = '';
							if($dish_id == $the_dish['id']){
								$sel = "selected";
							}
							echo "<option value='{$the_dish['id']}' {$sel}>{$the_dish['title']}</option>";
						} ?>
					</select>
					<input type="hidden" name="is_used" id="is_used" value="<?php echo $is_used; ?>">
				</li>

				<li>
					<a href="<?php echo web_url('dish',array('op'=>'add_number','dish_id'=>$dish_id)); ?>" class="btn btn-warning btn-sm" style="margin-right:10px;">添加激活码</a>
				</li>
			</td>
		</tr>
		</tbody>
	</table>

<table class="table table-striped table-bordered table-hover">
  <tr>
    <th class="text-center" >游戏币种</th>
    <th class="text-center" >金额</th>
	<th class="text-center" style="width: 200px;">激活码</th>
    <th class="text-center" style="width: 230px;">创建时间</th>
    <th class="text-center" >操作</th>
  </tr>

		<?php if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
                	<td style="text-align:center;" class="">
						<?php  echo $item['title'];?>
                	</td>
					<td style="text-align:center;" class="">
						<?php  echo $item['marketprice'];?>
					</td>
					<td style="text-align:center;" >
						<?php  echo $item['number'];?>
					</td>											

					<td style="text-align:center;">
						<?php echo date("Y-m-d H:i:s",$item['createtime']); ?>
					</td>
					<td style="text-align:center;">
						<?php if($item['is_used']){ ?>
							<a  class="btn btn-xs btn-info" href="javascript:;"><i class="icon-edit"></i>&nbsp;已使用&nbsp;</a>&nbsp;&nbsp;
						<?php }else{ ?>
							<a  class="btn btn-xs btn-info" href="<?php  echo web_url('dish', array('id' => $item['id'], 'op' => 'add_number'))?>"><i class="icon-edit"></i>&nbsp;编&nbsp;辑&nbsp;</a>&nbsp;&nbsp;
						<?php } ?>
						&nbsp;&nbsp;					
					</td>
				</tr>
				<?php  } } ?>
 	
		</table>
		<input type="hidden" name="" class="ajax-id" value="">
		<?php  echo $pager;?>
<script language="javascript">

 //全选
 function selectAll(){
	if($("#selectAll").is(':checked')){
	    $(".dishvalue").prop("checked",true);
	}else{
		$(".dishvalue").prop("checked",false);
	}
 }

function getNumberByDish(obj){
	var dish_id = $(obj).val();
	var is_used = $("#is_used").val();
	var url = "<?php echo web_url('dish',array('op'=>'show_number'));?>";
	url = url + "&is_used="+is_used;
	if(dish_id != 0){
		url = url + "&id="+dish_id;
	}
	window.location.href = url;
}
</script>
<?php  include page('footer');?>
