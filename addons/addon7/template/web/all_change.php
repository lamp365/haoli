<?php defined('SYSTEM_IN') or exit('Access Denied');?><?php  include page('header');?>
<div class="panel with-nav-tabs panel-default" style="margin-top: 20px">	
	    <div class="panel-heading">
	            <ul class="nav nav-tabs">
					<li <?php if ($_GP['op'] =='change' || empty($_GP['op'])) {echo 'class="active"';}?> ><a href="<?php echo web_url('awardlist',array('op'=>'change'));?>" >积分商品列表</a></li>
					<li <?php if ($_GP['op'] == 'all_recorder') {echo 'class="active"';}?> ><a href="<?php echo web_url('applyed',array('id'=>$_GP['id'],'op'=>'all_recorder'));?>" >兑换记录</a></li>
	            </ul>
	    </div>
	    <div class="panel-body third-party">
	        <div class="tab-content">

            <div class="tab-pane fade in active" >
				<h3 class="header smaller lighter blue">兑换记录</h3>
				<li style="float:left;list-style-type:none;margin-bottom: 15px;">
					<select name="state" onchange="sel_by_status(this)" style="margin-right:10px;margin-top:10px;width: 100px; height:34px; line-height:28px; padding:2px 0">
						<option value="0" <?php if($_GP['status'] ==0){ echo "selected";}?>>全部记录</option>
						<option value="2" <?php if($_GP['status'] ==2){ echo "selected";}?>>兑换成功</option>
						<option value="3" <?php if($_GP['status'] ==3){ echo "selected";}?>>兑换失败</option>
						<option value="1" <?php if($_GP['status'] ==1){ echo "selected";}?>>正在申请</option>
					</select>
					&nbsp;
						<span class="btn btn-md btn-primary"  id="bat_success">批量审核成功</span>
						<span class="btn btn-md btn-danger" id="bat_fail">批量审核失败</span>

				</li>
				<br/>
						<table class="table table-striped table-bordered table-hover">
							<thead >
								<tr>
									<th style="text-align:center;max-width:40px;"><label for="choose_all"><input type="checkbox" value="" id="choose_all">全选</label></th>
									<th style="text-align:center;max-width:80px;">序号</th>
									<th style="text-align:center;width:160px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" >礼品</th>
									<th style="text-align:center;max-width:80px;">类型</th>
									<th style="text-align:center;max-width:120px;">兑换时间</th>
								    <th style="text-align:center; max-width:90px;">姓名</th>
								    <th style="text-align:center; max-width:90px;">微信名</th>
								    <th style="text-align:center; max-width:90px;">电话</th>
									<th style="text-align:center; min-width:180px;">地址</th>
									<th style="text-align:center; min-width:120px;">操作</th>
								</tr>
							</thead>
							
							<tbody>
								<?php  if(is_array($awardlist)) { foreach($awardlist as $key=>$item) { ?>
								<tr>
									<td style="text-align:center;">
										<?php if($item['status'] != 1){ $dis="disabled";}else{ $dis = '';} ?>
										<input type="checkbox" name="id" value="<?php echo $item['id'];?>" class="choose_son" <?php echo $dis; ?>>
									</td>
									<td style="text-align:center;"><?php  echo ++$key;?></td>
									<td style="text-align:center;width:160px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php  echo $item['g_title'];?></td>
									<td style="text-align:center;"><?php  if($item['award_type'] ==1 ){ echo '自定义';}else if($item['award_type'] ==2){ echo '优惠卷';}else{ echo '自有商品';} ?></td>
									<td style="text-align:center;"><?php  echo date("Y-m-d H:i:s",$item['createtime']);?></td>
									<td style="text-align:center;"><?php  echo $item['pc_name']."({$item['m_mobile']})";?></td>
									<td style="text-align:center;"><?php  echo $item['wx_name'];?></td>
									<td style="text-align:center;"><?php  echo $item['mobile'];?></td>
									<td style="text-align:center;"><?php  echo "<font color='red'>{$item['credit']}</font> ".$item['address'];?></td>
									<td style="text-align:center;">
										<?php if($item['status'] == 1){ ?>
												<a class="btn btn-xs btn-primary" href="<?php echo web_url('applyed',array('id'=>$item['id'],'status'=>2,'op'=>'checked'));?>">审核成功</a>
												<a class="btn btn-xs btn-warning" href="<?php echo web_url('applyed',array('id'=>$item['id'],'status'=>3,'op'=>'checked'));?>">审核失败</a>
										<?php }else if($item['status'] == 2){ ?>
											<span class="btn btn-xs btn-success">兑换成功</span>
										<?php }else if($item['status'] == 3){?>
											<span class="btn btn-xs btn-danger">兑换失败</span>
										<?php } ?>
									</td>
								</tr>
								<?php  } } ?>
							</tbody>
						</table>
				        <?php echo $pager; ?>
	            </div>
			<script>
				function sel_by_status(obj){
					var status = $(obj).val();
					var url = "<?php echo web_url('applyed',array('op'=>'all_recorder'));?>";
					url = url+"&status="+status;
					window.location.href = url;
				}
				$("#choose_all").click(function(){
					var ischeck = this.checked;
					if(ischeck){
						$(".choose_son").each(function(index,thisObj){
							if($(thisObj).prop("disabled")==false){
								$(thisObj).prop('checked',true);
							}
						});
					}else{
						$(".choose_son").prop('checked',false);
					}
				})
				$("#bat_success").click(function(){
					confirm('确认批量审核','',function(isconfirm){
						if(isconfirm){
							var id_arr = [];
							$(".choose_son").each(function(index,thisObj){
								if($(thisObj).prop("checked")==true){
									id_arr.push($(thisObj).val());
								}
							});
							if(id_arr.length<1){
								alert('请先选择要操作的兑换记录');
								return '';
							}
							var url = "<?php echo web_url('applyed',array('op'=>'checked','status'=>2));?>";
							$.post(url,{'id':id_arr},function(data){
								var errno = data.errno;
								alert(data.message,'',function(){
									if(errno == 200){
										window.location.reload();
									}
								},{type:'success'});
							},"json")
						}
					},{confirmButtonText: '确认审核', cancelButtonText: '稍后审核', width: 400});
				})
				$("#bat_fail").click(function(){
					confirm('确认批量审核','',function(isconfirm){
						if(isconfirm){
							var id_arr = [];
							$(".choose_son").each(function(index,thisObj){
								if($(thisObj).prop("checked")==true){
									id_arr.push($(thisObj).val());
								}
							});
							if(id_arr.length<1){
								alert('请先选择要操作的兑换记录');
								return '';
							}
							var url = "<?php echo web_url('applyed',array('op'=>'checked','status'=>3));?>";
							$.post(url,{'id':id_arr},function(data){
								var errno = data.errno;
								alert(data.message,'',function(){
									if(errno == 200){
										window.location.reload();
									}
								},{type:'success'});
							},"json")
						}
					},{confirmButtonText: '确认审核', cancelButtonText: '稍后审核', width: 400});
				})
			</script>
	        </div>
	    </div>

<?php  include page('footer');?>