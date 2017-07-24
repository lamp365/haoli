<?php
/**
 * Created by PhpStorm.
 * User: 刘建凡
 * Date: 2017/4/7
 * Time: 18:29
 * demo
 * service 层 用于简化 我们的控制器，让控制器尽量再 简洁
 * 把一些业务提取出来，放在service层中去操作
$a = new \service\shop\goodsService();
if($a->todo()){
    //操作成功 则继续业务
}else{
    message($a->getError());
}
 */
namespace service\shop;

class outgoldService extends \service\publicService
{
    /**
     * 获取银行卡列表
     * @return array|bool
     */
    public function get_bank_list($openid)
    {
        $bank_array = array('all'=>array(),'bank'=>array(),'ali'=>array());
        $bank_list  = mysqld_selectall("select * from ".table('member_bank')." where openid='{$openid}'");
        //在获取卡的 对应背景图
        foreach($bank_list as $item){

            //获取银行卡图片
            $bank_bg = mysqld_select("select * from ".table('bank_img')." where bank='{$item['bank_name']}'");
            $item['card_icon'] = $bank_bg['card_icon'];
            $item['card_bg']   = $bank_bg['card_bg'];
            $item['bg_color']  = $bank_bg['bg_color'];

            //  ************************2355
            $weihao   = mb_substr($item['bank_number'], -4, 4, 'utf-8');
            $xing     = str_repeat("*",strlen($item['bank_number'])-4);
            $item['bank_bumber_star'] = $xing.$weihao;
            //  尾号8661
            $item['bank_bumber_wei']  =  $weihao;

            $bank_array['all'][] = $item;
            if($item['type'] == 1){
                $bank_array['bank'][] = $item;
            }else if($item['type'] == 2){
                $bank_array['ali'][] = $item;
            }
        }

        return $bank_array;
    }

    /**
     * 添加或者编辑银行卡账户
     * @step  用于app操作的时候 分解动作 1和2  而且是银行卡的时候才分解  支付宝不分解
     * @param $data
     * @return bool
     */
    public function add_zhanghu($data,$openid)
    {
        if(empty($data['bank_number'])){
            $this->error = '账户号码不能为空！';
            return false;
        }

        if(!in_array($data['type'],array(1,2))){
            $this->error = '类型参数有误！';
            return false;
        }
        if($data['type'] == 1){
            if(!checkBankIsRight($data['bank_number'])){
                $this->error = '银行卡不是合法的！';
                return false;
            }
            if(empty($data['card_own'])){
                $this->error = '持卡人信息未填写！';
                return false;
            }
        }


        $card_info = array();

        if($data['type'] == 1){
            //银行卡
            $card_info = bankInfo($data['bank_number']);
            $card_info = explode('-',$card_info);
            $bank_name = '';
        }else{
            $bank_name = '支付宝';
        }

        $bank_name = $bank_name ?: $card_info[0];  //建设
        $card_type = $card_info[1];  //龙卡通
        $card_kind = $card_info[2];  //储蓄卡  借记卡

        $action_data  = array(
            'bank_name'   => $bank_name,
            'openid'      => $openid,
            'bank_number' => $data['bank_number'],
            'card_type'   => $card_type,
            'card_kind'   => $card_kind,
            'card_own'    => $data['card_own'],
            'type'        => intval($data['type']),
        );

        if(empty($data['id'])){
            mysqld_insert('member_bank',$action_data);
            $res = mysqld_insertid();
            if($res){
                //把当前的卡设置为 默认
                set_bank_default($openid,$res);
            }
            $action_data['id'] = $res;
        }else{
            //编辑
            $res = mysqld_update('member_bank',$action_data,array('id'=>$data['id']));
            $action_data['id'] = $data['id'];
        }
        if($res){
            return $action_data;
        }else{
            $this->error = '操作失败！';
            return false;
        }
    }

    /**
     * 提交提款的表单提交操作
     * @param $data
     * @return bool
     */
    public function do_outgold($data,$openid)
    {
        if(empty($data['bank_id'])){
            $this->error = '请选择提款账户';
            return false;
        }
        if(empty($data['money']) || !is_numeric($data['money'])){
            $this->error = '金额不能为空并且必须是数字！';
            return false;
        }

        $config = globaSetting();
        $store_info     = mysqld_select('select * from '.table('shop_money'));
        $recharge_money = $store_info['money']; //余额

        $money         = $data['money'];    //要提款的金额
        $rate_money    = round(($config['teller_rate']/100)*$money,2);
        $compare_money = $money + $rate_money;

        if($recharge_money <= $compare_money){
            //提款加上手续费 大于余额
            $this->error = "您的余额不足以抵扣费率{$rate_money}元";
            return false;
        }

        if($money < $config['teller_limit']){
            $this->error = "最低提款金额为{$config['teller_limit']}元";
            return false;
        }

        //获取提款账户
        $bank_info = mysqld_select("select * from ".table('member_bank')." where id={$data['bank_id']} and openid='{$openid}'");
        if(empty($bank_info)){
            $this->error = '提款账户不存在';
            return false;
        }

        $ordersn    = 'rg'.date('YmdHis') .uniqid();
        mysqld_insert('gold_teller',array(
            'bank_name'=>$bank_info['bank_name'],
            'bank_id'  =>$bank_info['bank_number'],
            'openid'   =>$openid,
            'fee'      =>$money,
            'status'   =>0,
            'ordersn'    =>$ordersn,
            'rate_money' =>$rate_money,
            'createtime' =>time()
        ));
        if($cash_id = mysqld_insertid()){
            if($bank_info['type'] == 2){
                $remark = \PayLogEnum::getLogTip('LOG_OUTMONEY_ALI_TIP');
            }else{
                $weihao  = mb_substr($bank_info['bank_number'], -4, 4, 'utf-8');
                $replace = $bank_info['bank_name']."({$weihao})";
                $remark  = \PayLogEnum::getLogTip('LOG_OUTMONEY_BANK_TIP',$replace);
            }
            //记录paylog
            $pid   = member_gold($openid,$compare_money,'usegold',$remark,false);

            //平台资金 扣除
            $sql = "update ".table('shop_money')." set money=money-{$compare_money}";
            mysqld_query($sql);

            //本次 账单记录为 提现，还需要记录 账单的 提现id
            mysqld_update('member_paylog',array('cash_id'=>$cash_id,'check_step'=>1),array('pid'=>$pid));

            //把本次的银行卡设置为默认
            set_bank_default($openid,$data['bank_id']);
            return true;
        }else{
            $this->error = '余额提现申请失败';
            return false;
        }
    }

    public function jishuMoney($jishu_rate)
    {
        if(empty($jishu_rate)){
            return 0;
        }
        $today_zero  = strtotime(date("Y-m-d"));   //今天凌晨时间点
        $curt_day    = date('d')-1; //当前天数
        $e_time      = time();
        $s_time      = $today_zero - 3600*24*$curt_day;  //当月1号时间
//        echo date('Y-m-d H:i:s',$s_time);
//        echo date('Y-m-d H:i:s',$e_time);
        //获取收益 与已经支付订单量
        $pay_info = mysqld_select("SELECT  sum(price) as price FROM ".table('shop_order')." WHERE status >= 1 and paytime >=".$s_time." and paytime<=".$e_time);
        if(empty($pay_info)){
            $money = 0;
        }else{
            $money = $pay_info['price'];
        }

        if($money >= 2000){
            $money = round(($jishu_rate/100)*$money,2);
        }else{
            $money = 0;
        }
        return $money;

    }

}