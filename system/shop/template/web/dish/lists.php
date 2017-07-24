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
</style>
<br/>
<table class="table table-striped table-bordered table-hover">
  <tr>
    <th class="text-center" style="width: 90px;">
    	<input type="checkbox" onclick="selectAll()" id="selectAll"/>
    	宝贝ID
    </th>

    <th class="text-center" >游戏币种</th>
    <th class="text-center" >金额</th>
	<th class="text-center" style="width: 200px;">激活码库存</th>
    <th class="text-center" style="width: 130px;">状态</th>
    <th class="text-center" >操作</th>
  </tr>

		<?php if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
				 	<td style="text-align:center;" class="dish-id">
				 		<input type="checkbox" class="dishvalue" name="disvalue[]" value="<?php  echo $item['id'];?>"/>
				 		<?php  echo $item['id'];?>				 			
				 	</td>
                	<td style="text-align:center;" class="product-title">
                		<input type="text" name="" class="modify-title form-control modify-input" ajax-title-id="<?php  echo $item['id'];?>">
                		<span class="product-title-a"><?php  echo $item['title'];?></span>
                		<i class="modify-icon icon-pencil"></i>
                	</td>
					<td style="text-align:center;" >
						<?php  echo $item['marketprice'];?>
					</td>
					<td style="text-align:center;" >
						<?php  echo $item['number_total'];?>
					</td>											

					<td style="text-align:center;">
						<?php  if($item['status']) { ?>
						<span data-status='0' onclick="setDishStatus(this,<?php  echo $item['id'];?>)" class="label label-success" style="cursor:pointer;">已上架</span>
						<?php  } else { ?>
						<span data-status='1' onclick="setDishStatus(this,<?php  echo $item['id'];?>)" class="label label-danger" style="cursor:pointer;">已下架</span>
						<?php  } ?>

					</td>
					<td style="text-align:center;">
						<a  class="btn btn-xs btn-info" href="<?php  echo web_url('dish', array('id' => $item['id'], 'op' => 'show_number'))?>"><i class="icon-edit"></i>&nbsp;激活码&nbsp;</a>&nbsp;&nbsp;
						<a  class="btn btn-xs btn-info" href="<?php  echo web_url('dish', array('id' => $item['id'], 'op' => 'post'))?>"><i class="icon-edit"></i>&nbsp;编&nbsp;辑&nbsp;</a>&nbsp;&nbsp;
						<a  class="btn btn-xs btn-danger" href="<?php  echo web_url('dish', array('id' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;"><i class="icon-edit"></i>&nbsp;删&nbsp;除&nbsp;</a>
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
 function modify(){
 	 //修改标题操作
	$(".modify-icon").on("click",function(){
		var titleVal = $(this).siblings(".product-title-a").text();
	 	$(this).siblings(".modify-title").show().focus();
	 	$(this).siblings(".modify-title").val(titleVal);
	});
	$(".modify-title").blur(function(){
		var id = $(this).attr("ajax-title-id");
		var title = $(this).val();
		var this_title = $(this);
		var url = "<?php echo web_url('dish',array('op'=>'ajax_title')); ?>";
		$.post(url,{ajax_id:id,ajax_title:title},function(data){
			if( data.errno == 200 ){
				this_title.siblings(".product-title-a").text(data.message);
				$(this).hide();
			}else{
				alert(data.message);
				$(this).hide();
			}
		},"json");
		$(this).hide();
	});

 }
modify();

function setDishStatus(obj,dishid){
	var url = "<?php  echo web_url('dish', array('op' => 'ajax_dishstatus'))?>";
	var status = $(obj).data('status');
	$.post(url,{dishid:dishid,status:status},function(data){
		if(data.errno == 200){
			if(status == 0){
				//设置下架的
				$(obj).removeClass('label-success');
				$(obj).addClass('label-danger');
				$(obj).data('status',1);  //修改为1  下次就是要上架
				$(obj).html('已下架');
			}else{
				//设置上架的
				$(obj).removeClass('label-danger');
				$(obj).addClass('label-success');
				$(obj).data('status',0);  //修改为1  下次就是要下架
				$(obj).html('已上架');
			}
		}else{
			alert(data.message);
		}
	},'json');
}
</script>
<?php  include page('footer');?>
