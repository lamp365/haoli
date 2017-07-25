<?php defined('SYSTEM_IN') or exit('Access Denied');?><?php  include page('header');?>
<h3 class="header smaller lighter blue">财付通配置</h3>
<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-left" > 支付名称：</label>

		<div class="col-sm-9">
			<?php  echo $item['name'];?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-left" > 支付描述：</label>

		<div class="col-sm-9">
			<?php  echo $item['desc'];?>
		</div>
	</div>



	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-left" > 安全校验码(Key)：</label>

		<div class="col-sm-3">
			<input type="text" name="tenpay_key" class="form-control" value="<?php  echo $configs['tenpay_key'];?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-left" > 合作者身份(partner)：</label>

		<div class="col-sm-3">
			<input type="text" name="tenpay_partner" class="form-control" value="<?php  echo $configs['tenpay_partner'];?>" />
		</div>
	</div>





	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-left" > 申请地址：</label>

		<div class="col-sm-9">
			<a href="https://www.tenpay.com/v3/" target="_blank" style="color:red">财付通申请地址</a>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-left" > 排序优先级：</label>

		<div class="col-sm-3">
			<input type="text" class="form-control" name="pay_order" value="<?php  echo $item['order'];?>" />
			<p class="help-block">越大支付时候显示越前</p>
		</div>
	</div>




	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-left" for="form-field-1"> </label>

		<div class="col-sm-9">
			<input name="submit" type="submit" value=" 提 交 " class="btn btn-info"/>

		</div>
	</div>
</form>
