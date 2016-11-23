<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 20:11
 */

namespace Home\Model;


use Think\Model;

class CartModel extends Model
{
    public function getCartList()
    {
        //获取购物车数据
        //是否登录
        $total_price = 0.00;
        if ($user = session('USER_INFO')) {
            $cart = $this->where(['member_id' => $user['id']])->getField('goods_id,amount');
        } else {//未登录
            $cart = cookie('CART_INFO');
        }
        $goods_ids = array_keys($cart);
        if (empty($goods_ids)) {
            $goods_detail = [];
        } else {
            $goods_detail = D('Goods')->getGoodsByGoodsIds($goods_ids);
            foreach ($goods_detail as $k => $v) {
                $v['amount'] = $cart[$k];
                $v['sub_total'] = number_format($cart[$k] * $v['shop_price'], 2, '.', '');
                $goods_detail[$k] = $v;
                $total_price += $v['sub_total'];
            }
        }
        $total_price = number_format($total_price,2,'.','');

        return [
            'total_price' => $total_price,
            'goods_detail' => $goods_detail,
        ];
    }
}