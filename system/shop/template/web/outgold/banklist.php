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
<a href="<?php echo web_url('outgold',array('op'=>'setbank')) ?>" class="btn btn-md btn-info" style="margin-bottom:15px;">添加账户</a><br/>
<table class="table table-striped table-bordered table-hover">
    <tr>
        <th class="text-center" style="width: 90px;">
            序号
        </th>

        <th class="text-center" >账户名称</th>
        <th class="text-center" >账户号码</th>
        <th class="text-center" style="">账户类型</th>
        <th class="text-center" style="">持卡人姓名</th>
        <th class="text-center" >操作</th>
    </tr>

    <?php if(is_array($bank_list['all'])) { foreach($bank_list['all'] as $key=> $bank) { ?>
        <tr>
            <td style="text-align:center;" class="dish-id">
                <?php  echo $key++;?>
            </td>
            <td style="text-align:center;" >
                <?php echo $bank['bank_name']; ?>
            </td>
            <td style="text-align:center;" >
                <?php echo $bank['bank_number']; ?>
            </td>
            <td style="text-align:center;" >
                <?php echo $bank['card_kind']; ?>
            </td>

            <td style="text-align:center;">
                <?php echo $bank['card_own']; ?>

            </td>
            <td style="text-align:center;">
                <a  class="btn btn-xs btn-info" href="<?php echo web_url('outgold',array('op'=>'setbank','id'=>$bank['id'])) ?>"><i class="icon-edit"></i>&nbsp;编&nbsp;辑&nbsp;</a>&nbsp;&nbsp;
                <a  class="btn btn-xs btn-danger" href="<?php  echo web_url('outgold', array('id' => $item['id'], 'op' => 'delbank'))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;"><i class="icon-edit"></i>&nbsp;删&nbsp;除&nbsp;</a>
                &nbsp;&nbsp;
            </td>
        </tr>
    <?php  } } ?>

</table>

<script language="javascript">

</script>
<?php  include page('footer');?>
