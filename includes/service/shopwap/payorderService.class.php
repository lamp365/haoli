<?php
namespace service\shopwap;

class payorderService extends  \service\publicService
{
    /**
     * 插入订单 参数
     * array(
            buy_num  => 2
            dish_id  => '2'
            paytype  => ali
     * )
     * @param $data
     * @return bool
     */
    public function insertOrder($data)
    {
        $memInfo  = get_member_account();
        $openid   = $memInfo['openid'];
        $pay_ordersn     = '';
        $pay_total_money = 0;
        $pay_title       = '';

        if(empty($data['dish_id'])){
            $this->error = '请选择对应游戏币种！';
            return false;
        }
        //获取商品
        $dish = mysqld_select("select * from ".table('shop_dish')." where id={$data['dish_id']}");
        if(empty($dish) || $dish['deleted'] == 1){
            $this->error = '该游戏币种不存在！';
            return false;
        }
        if($dish['status'] == 0){
            $this->error = '该游戏币种已下架！';
            return false;
        }

        $buy_num = intval($data['buy_num']) ?: 1;

        //获取库存
        $total_number = mysqld_selectcolumn("select count(id) from ".table('dish_number')." where dish_id={$data['dish_id']} and is_used=0");
        if($buy_num > $total_number){
            $this->error = "该游戏币种库存剩下{$total_number}个！";
            return false;
        }


        $ordersns    = 'SN'.date('Ymd') . random(6, 1);
        $randomorder = mysqld_select("SELECT * FROM " . table('shop_order') . " WHERE  ordersn=:ordersn limit 1", array(':ordersn' =>$ordersns));
        if(!empty($randomorder['ordersn'])) {
            $ordersns= 'SN'.date('Ymd') . random(6, 1);
        }
        $pay_ordersn      = $ordersns;
        $pay_total_money  = $dish['marketprice'] * $buy_num;
        $pay_title        = str_replace('&','',$dish['title']);  //去除带有 & 的字符
        $pay_title        = str_replace("'", '‘', $pay_title);
        $pay_title        = str_replace(" ", '', $pay_title);

        if($data['paytype'] == 'ali'){
            $paytypecode = 1;
        }else if($data['paytype'] == 'weixin'){
            $paytypecode = 2;
        }
        $order_data = array();
        $order_data['openid']           = $openid;
        $order_data['ordersn']          = $ordersns;
        $order_data['ordertype']        = 0;                        //普通订单
        $order_data['price']            = $pay_total_money;    //需要支付的总金额
        $order_data['goodsprice']       = $pay_total_money;              //商品价格
        $order_data['dispatchprice']    = 0;             //运费
        $order_data['status']           = 0;             //状态未付款
        $order_data['source']           = get_mobile_type(1);    //设备来源
        $order_data['sendtype']         = 0;    //快递发货
        $order_data['paytype']          = 2;    //在线付款
        $order_data['paytypecode']      = $paytypecode;    //微信支付
        $order_data['paytypename']      = $data['paytype'];    //支付类型名称
        $order_data['addressid']        = 0;
        $order_data['createtime']       = time();
        $order_data['address_realname'] = '';
        $order_data['address_province'] = '';
        $order_data['address_city']     = '';
        $order_data['address_area']     = '';
        $order_data['address_address']  = '';
        $order_data['address_mobile']   = '';

        mysqld_insert('shop_order',$order_data);
        $orderid = mysqld_insertid();
        if($orderid){
            $is_error = false;
            for($j=1;$j<=$buy_num;$j++){
                //取出一个激活码
                $the_number = mysqld_select("select * from ".table('dish_number')." where dish_id={$data['dish_id']} and is_used=0");
                $o_good = array();
                $o_good['openid']                = $openid;
                $o_good['orderid']               = $orderid;
                $o_good['goodsid']               = $dish['id'];
                $o_good['dish_number']           = $the_number['number'];
                $o_good['dnumber_id']            = $the_number['id'];
                $o_good['price']                 = $dish['marketprice'];
                $o_good['total']                 = 1;
                $o_good['createtime']            = time();
                $res2 = mysqld_insert('shop_order_goods',$o_good);
                if(!$res2){
                    $is_error = true;
                    //如果不成功  把提交给第三方的总额中去除该商品的价格
                    $pay_total_money = $pay_total_money -  $o_good['price'];
                }else{
                    //库存的操作减掉 卖出数量加1
                    mysqld_update('dish_number',array('is_used'=>1),array('id'=>$the_number['id']));
                }

            }

            //有一个是限时购的 该订单表示限时购订单
            if($is_error){
                mysqld_update('shop_order',array('price'=>$pay_total_money,'goodsprice'=>$pay_total_money),array('id'=>$orderid));
            }

        }

        $re_data = array(
            'pay_ordersn'     => $pay_ordersn,
            'pay_total_money' => $pay_total_money,
            'pay_title'       => $pay_title
        );
        return $re_data;
    }

    public function getPayOrder($orderid)
    {
        $memInfo = get_member_account();
        if(empty($orderid)){
            $this->error = '参数有误！';
            return false;
        }
        $order = mysqld_select("select id,ordersn,price,status from ".table('shop_order')." where id={$orderid} and openid='{$memInfo['openid']}'");
        if(empty($order)){
            $this->error = '订单不存在！';
            return false;
        }
        if($order['status']!=0){
            $this->error = '订单已经支付！';
            return false;
        }

        $o_sql   = "select h.title from ".table('shop_order_goods')." as g left join ".table('shop_dish')." as h";
        $o_sql  .= " on g.dishid=h.id where g.orderid={$order['id']}";
        $o_goods = mysqld_select($o_sql);
        $pay_title = str_replace('&','',$o_goods['title']);

        return array(
            'pay_ordersn'     => $order['ordersn'],   //单个订单号
            'pay_total_money' => $order['price'],
            'pay_title'       => $pay_title,
        );
    }
}
