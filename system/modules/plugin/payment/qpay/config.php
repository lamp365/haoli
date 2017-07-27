<?php defined('SYSTEM_IN') or exit('Access Denied');?><?php  include page('header');?>
<h3 class="header smaller lighter blue"><?php  echo $item['name'];?>配置</h3>
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
			<input type="text" name="qpay_MCH_KEY" class="form-control" value="<?php  echo $configs['qpay_MCH_KEY'];?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-left" > QQ商户号：</label>

		<div class="col-sm-3">
			<input type="text" name="qpay_MCH_ID" class="form-control" value="<?php  echo $configs['qpay_MCH_ID'];?>" />
		</div>
	</div>





	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-left" > 申请地址：</label>

		<div class="col-sm-9">
			<a href="https://qpay.qq.com/?ADTAG=tenpay_v3.homepage.ad.qqwallet" target="_blank" style="color:red">QQ商家申请地址</a>
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
