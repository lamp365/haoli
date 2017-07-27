<?php 

		
				
          $payment = mysqld_select("SELECT * FROM " . table('payment') . " WHERE  enabled=1 and code='qpay' limit 1");
          $configs=unserialize($payment['configs']);

         message( $configs['bank_pay_desc'],WEBSITE_ROOT.mobile_url('myorder'),'success',false);
			
?>