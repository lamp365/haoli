<?php defined('SYSTEM_IN') or exit('Access Denied');?><?php  include page('header');?>
<script type="text/javascript" src="<?php echo RESOURCE_ROOT;?>/addons/common/laydate/laydate.js"></script>
<style type="text/css">
    .panel.with-nav-tabs .panel-heading{
        padding: 5px 5px 0 5px;
    }
    .panel.with-nav-tabs .nav-tabs{
        border-bottom: none;
    }
    .panel.with-nav-tabs .nav-justified{
        margin-bottom: -1px;
    }
    /********************************************************************/
    /*** PANEL DEFAULT ***/
    .with-nav-tabs.panel-default .nav-tabs > li > a,
    .with-nav-tabs.panel-default .nav-tabs > li > a:hover,
    .with-nav-tabs.panel-default .nav-tabs > li > a:focus {
        color: #777;
    }
    .with-nav-tabs.panel-default .nav-tabs > .open > a,
    .with-nav-tabs.panel-default .nav-tabs > .open > a:hover,
    .with-nav-tabs.panel-default .nav-tabs > .open > a:focus,
    .with-nav-tabs.panel-default .nav-tabs > li > a:hover,
    .with-nav-tabs.panel-default .nav-tabs > li > a:focus {
        color: #777;
        background-color: #ddd;
        border-color: transparent;
    }
    .with-nav-tabs.panel-default .nav-tabs > li.active > a,
    .with-nav-tabs.panel-default .nav-tabs > li.active > a:hover,
    .with-nav-tabs.panel-default .nav-tabs > li.active > a:focus {
        color: #555;
        background-color: #fff;
        border-color: #ddd;
        border-bottom-color: transparent;
    }
    .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu {
        background-color: #f5f5f5;
        border-color: #ddd;
    }
    .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a {
        color: #777;
    }
    .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
    .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
        background-color: #ddd;
    }
    .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a,
    .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
    .with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
        color: #fff;
        background-color: #555;
    }
    /********************************************************************/
    /*** PANEL PRIMARY ***/
    .with-nav-tabs.panel-primary .nav-tabs > li > a,
    .with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
    .with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
        color: #fff;
    }
    .with-nav-tabs.panel-primary .nav-tabs > .open > a,
    .with-nav-tabs.panel-primary .nav-tabs > .open > a:hover,
    .with-nav-tabs.panel-primary .nav-tabs > .open > a:focus,
    .with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
    .with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
        color: #fff;
        background-color: #3071a9;
        border-color: transparent;
    }
    .with-nav-tabs.panel-primary .nav-tabs > li.active > a,
    .with-nav-tabs.panel-primary .nav-tabs > li.active > a:hover,
    .with-nav-tabs.panel-primary .nav-tabs > li.active > a:focus {
        color: #428bca;
        background-color: #fff;
        border-color: #428bca;
        border-bottom-color: transparent;
    }
    .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu {
        background-color: #428bca;
        border-color: #3071a9;
    }
    .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a {
        color: #fff;
    }
    .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
    .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
        background-color: #3071a9;
    }
    .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a,
    .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
    .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
        background-color: #4a9fe9;
    }
    /********************************************************************/
    /*** PANEL SUCCESS ***/
    .with-nav-tabs.panel-success .nav-tabs > li > a,
    .with-nav-tabs.panel-success .nav-tabs > li > a:hover,
    .with-nav-tabs.panel-success .nav-tabs > li > a:focus {
        color: #3c763d;
    }
    .with-nav-tabs.panel-success .nav-tabs > .open > a,
    .with-nav-tabs.panel-success .nav-tabs > .open > a:hover,
    .with-nav-tabs.panel-success .nav-tabs > .open > a:focus,
    .with-nav-tabs.panel-success .nav-tabs > li > a:hover,
    .with-nav-tabs.panel-success .nav-tabs > li > a:focus {
        color: #3c763d;
        background-color: #d6e9c6;
        border-color: transparent;
    }
    .with-nav-tabs.panel-success .nav-tabs > li.active > a,
    .with-nav-tabs.panel-success .nav-tabs > li.active > a:hover,
    .with-nav-tabs.panel-success .nav-tabs > li.active > a:focus {
        color: #3c763d;
        background-color: #fff;
        border-color: #d6e9c6;
        border-bottom-color: transparent;
    }
    .with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu {
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }
    .with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > li > a {
        color: #3c763d;
    }
    .with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
    .with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
        background-color: #d6e9c6;
    }
    .with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > .active > a,
    .with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
    .with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
        color: #fff;
        background-color: #3c763d;
    }
    /********************************************************************/
    /*** PANEL INFO ***/
    .with-nav-tabs.panel-info .nav-tabs > li > a,
    .with-nav-tabs.panel-info .nav-tabs > li > a:hover,
    .with-nav-tabs.panel-info .nav-tabs > li > a:focus {
        color: #31708f;
    }
    .with-nav-tabs.panel-info .nav-tabs > .open > a,
    .with-nav-tabs.panel-info .nav-tabs > .open > a:hover,
    .with-nav-tabs.panel-info .nav-tabs > .open > a:focus,
    .with-nav-tabs.panel-info .nav-tabs > li > a:hover,
    .with-nav-tabs.panel-info .nav-tabs > li > a:focus {
        color: #31708f;
        background-color: #bce8f1;
        border-color: transparent;
    }
    .with-nav-tabs.panel-info .nav-tabs > li.active > a,
    .with-nav-tabs.panel-info .nav-tabs > li.active > a:hover,
    .with-nav-tabs.panel-info .nav-tabs > li.active > a:focus {
        color: #31708f;
        background-color: #fff;
        border-color: #bce8f1;
        border-bottom-color: transparent;
    }
    .with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu {
        background-color: #d9edf7;
        border-color: #bce8f1;
    }
    .with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a {
        color: #31708f;
    }
    .with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
    .with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
        background-color: #bce8f1;
    }
    .with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a,
    .with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
    .with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
        color: #fff;
        background-color: #31708f;
    }
    /********************************************************************/
    /*** PANEL WARNING ***/
    .with-nav-tabs.panel-warning .nav-tabs > li > a,
    .with-nav-tabs.panel-warning .nav-tabs > li > a:hover,
    .with-nav-tabs.panel-warning .nav-tabs > li > a:focus {
        color: #8a6d3b;
    }
    .with-nav-tabs.panel-warning .nav-tabs > .open > a,
    .with-nav-tabs.panel-warning .nav-tabs > .open > a:hover,
    .with-nav-tabs.panel-warning .nav-tabs > .open > a:focus,
    .with-nav-tabs.panel-warning .nav-tabs > li > a:hover,
    .with-nav-tabs.panel-warning .nav-tabs > li > a:focus {
        color: #8a6d3b;
        background-color: #faebcc;
        border-color: transparent;
    }
    .with-nav-tabs.panel-warning .nav-tabs > li.active > a,
    .with-nav-tabs.panel-warning .nav-tabs > li.active > a:hover,
    .with-nav-tabs.panel-warning .nav-tabs > li.active > a:focus {
        color: #8a6d3b;
        background-color: #fff;
        border-color: #faebcc;
        border-bottom-color: transparent;
    }
    .with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu {
        background-color: #fcf8e3;
        border-color: #faebcc;
    }
    .with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > li > a {
        color: #8a6d3b;
    }
    .with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
    .with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
        background-color: #faebcc;
    }
    .with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > .active > a,
    .with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
    .with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
        color: #fff;
        background-color: #8a6d3b;
    }
    /********************************************************************/
    /*** PANEL DANGER ***/
    .with-nav-tabs.panel-danger .nav-tabs > li > a,
    .with-nav-tabs.panel-danger .nav-tabs > li > a:hover,
    .with-nav-tabs.panel-danger .nav-tabs > li > a:focus {
        color: #a94442;
    }
    .with-nav-tabs.panel-danger .nav-tabs > .open > a,
    .with-nav-tabs.panel-danger .nav-tabs > .open > a:hover,
    .with-nav-tabs.panel-danger .nav-tabs > .open > a:focus,
    .with-nav-tabs.panel-danger .nav-tabs > li > a:hover,
    .with-nav-tabs.panel-danger .nav-tabs > li > a:focus {
        color: #a94442;
        background-color: #ebccd1;
        border-color: transparent;
    }
    .with-nav-tabs.panel-danger .nav-tabs > li.active > a,
    .with-nav-tabs.panel-danger .nav-tabs > li.active > a:hover,
    .with-nav-tabs.panel-danger .nav-tabs > li.active > a:focus {
        color: #a94442;
        background-color: #fff;
        border-color: #ebccd1;
        border-bottom-color: transparent;
    }
    .with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu {
        background-color: #f2dede; /* bg color */
        border-color: #ebccd1; /* border color */
    }
    .with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > li > a {
        color: #a94442; /* normal text color */
    }
    .with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
    .with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
        background-color: #ebccd1; /* hover bg color */
    }
    .with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > .active > a,
    .with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
    .with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
        color: #fff; /* active text color */
        background-color: #a94442; /* active bg color */
    }
    .time_put{
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;

    }
    .thumbnail>img{height: 100%;}

    .zhifubao,.weixin,.bank,.banks-area{
        display: none;
    }
    .zhifubao li i{
        color: #a6a6a6;
        margin-left: 10px;
    }
    .zhifubao li i.checked{
        color: #43ae36;
    }
    .zhifubao li.checked,.zhifubao li.checked i{
        color: #43ae36;
    }
    .zhifubao li{
        padding-right: 10px;
        cursor: pointer;
        margin-right: 10px;
        float: left;
        border-right: 1px dotted #8b8b8b;
    }
    .zhifubao li:last-child{
        border-right:none;
    }
    .weixin li i{
        color: #a6a6a6;
        margin-left: 10px;
    }
    .weixin li i.checked{
        color: #43ae36;
    }
    .weixin li.checked,.weixin li.checked i{
        color: #43ae36;
    }
    .weixin li{
        padding-right: 10px;
        cursor: pointer;
        margin-right: 10px;
        float: left;
        border-right: 1px dotted #8b8b8b;
    }
    .weixin li:last-child{
        border-right:none;
    }
    .bank li i{
        color: #a6a6a6;
        margin-left: 10px;
    }
    .bank li i.checked{
        color: #43ae36;
    }
    .bank li.checked,.bank li.checked i{
        color: #43ae36;
    }
    .bank li{
        padding-right: 10px;
        cursor: pointer;
        margin-right: 10px;
        float: left;
        border-right: 1px dotted #8b8b8b;
    }
    .bank li:last-child{
        border-right:none;
    }
    .banks-area ul{
        padding: 0px;
        margin: 0px;
    }
</style>
<br/>
<form action="<?php echo web_url('outgold',array('op'=>'do_outgold')); ?>" method="post" enctype="multipart/form-data" class="tab-content form-horizontal" role="form" onsubmit="return fillform()">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-body">

            <div class="tab-content">

                <div class="tab-pane fade in active" id="tab1primary">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-left" > 提款说明：</label>
                        <div class="col-sm-4" style="padding-top: 5px;">
                            每次最低提款<?php  echo $seting['teller_limit'];?>元，每次提款扣除 <a href="https://cshall.alipay.com/enterprise/knowledgeDetail.htm?knowledgeId=591311" target="_blank">费率</a>
                            为<?php  echo $seting['teller_rate'];?>%，即1000扣6块。
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-left" > 提款说明：</label>
                        <div class="col-sm-4" style="padding-top: 5px;">
                            当该平台月收入达到2000时，将给予技术一个支持的分成，<?php  echo $seting['jishu_rate'];?>%。
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-left" > 平台总收入：</label>
                        <div class="col-sm-4" style="padding-top: 5px;">
                            <?php  echo $sys_money['total_money'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-left" > 技术分成：</label>
                        <div class="col-sm-4" style="padding-top: 5px;">
                            <?php  echo number_format($jishuMoney,2);?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-left" > 平台总余额：</label>
                        <div class="col-sm-4" style="padding-top: 5px;">
                            <?php  echo $sys_money['money'];?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-left" > 提现到：</label>

                        <div class="col-sm-3">
                            <select name="" id="choose_bank" class="form-control">
                                <option value="0">选择类型</option>
                                <option value="bank">银行卡</option>
                                <option value="zhifubao">支付宝</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group banks-area">
                        <label class="col-sm-2 control-label no-padding-left" > </label>
                        <div class="col-sm-6">
                            <ul class="zhifubao clearfix">
                                <?php foreach($bank_list['ali'] as $one_zf){  ?>
                                    <li bankId="<?php echo $one_zf['id'];?>" class=""><?php echo $one_zf['bank_number'];?><i class="fa fa-check-circle" aria-hidden="true"></i></li>
                                <?php } ?>
                            </ul>
                            <ul class="bank clearfix">
                                <?php foreach($bank_list['bank'] as $one_bank){  ?>
                                    <li bankId="<?php echo $one_bank['id'];?>" class=" "><?php echo $one_bank['bank_name'].' 尾号'.$one_bank['bank_bumber_wei'].' '.$one_bank['card_kind'];?><i class="fa fa-check-circle" aria-hidden="true"></i></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-left" > 提款金额：</label>
                        <div class="col-sm-3" style="padding-top: 5px;">
                            <input type="text" name="money" value="" id="money" class="form-control span7" placeholder="请输入提款金额" required="">
                        </div>
                    </div>

                </div>

            </div>


        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-left" ></label>

            <div class="col-sm-9">
                <input type="hidden" value="" name="bank_id" id="bank_id">
                <button type="submit" class="btn btn-primary btn-md span2" name="submit" value="submit"><i class="icon-edit"></i>立即提现</button>
            </div>
        </div>
    </div>
</form>



<script language="javascript">


    function fillform()
    {
        if($("#money").val() == 0){
            alert('提款金额不能为空！');
            return false;
        }
        var limit_money = "<?php  echo $seting['teller_limit'];?>";
        limit_money = parseFloat(limit_money).toFixed(2);
        if(parseFloat($("#money").val()) < limit_money){
            alert('最低提款金额为'+limit_money);
            return false;
        }
        if($("#bank_id").val() == 0 || $("#bank_id").val() == ''){
            alert('请选择提款账户！');
            return false;
        }

        return true;
    }
    $("#choose_bank").change(function(){
        var val = $(this).val();
        $(".banks-area").show();
        $(".banks-area ul").hide();
        $("."+val).show();
        $("#bank_id").val('');
    });
    $(".zhifubao li").on("click",function(){
        if(!$(this).hasClass("checked")){
            $(this).addClass("checked");
            $(this).siblings("li").removeClass("checked");
            $("#bank_id").val($(this).attr("bankId"));
        }
    });

    $(".bank li").on("click",function(){
        if(!$(this).hasClass("checked")){
            $(this).addClass("checked");
            $(this).siblings("li").removeClass("checked");
            $("#bank_id").val($(this).attr("bankId"));
        }
    });

</script>
<?php  include page('footer');?>
