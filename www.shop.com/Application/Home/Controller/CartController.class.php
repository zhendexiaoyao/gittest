<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 15:23
 */

namespace Home\Controller;


use Think\Controller;

class CartController extends Controller
{
    private $_model = null;
    protected function _initialize(){
        $this->_model = D('Cart');
    }
    /**
     * 添加商品到购物车
     * @param $goods_id
     * @param $amount
     */
    public function add2cart($goods_id,$amount){
        //判断用户是否登录
        if($user = session('USER_INFO')){
            $cond = ['goods_id'=>$goods_id,'member_id'=>$user['id']];
           $db_amount = $this->_model->where($cond)->getField('amount');
            //有这个产品就数量相加
            if ($db_amount) {
                $this->_model->where($cond)->setInc('amount',$amount);
            }else{
                //没有这个产品就加入数据表中
                $data = [
                    'goods_id'=>$goods_id,
                    'member_id'=>$user['id'],
                    'amount'=>$amount
                ];
                $this->_model->add($data);
            }
        }else{
            //设置产品的id为键名数量为键值，判断先前购物车是否有此商品
            $cart = cookie('CART_INFO');
            if (isset($cart[$goods_id])) {
                $cart[$goods_id] += $amount;
            }else{//之前有此商品就加数量没有就加商品
                $cart[$goods_id] = $amount;
            }
            //将购物车信息存入cookie
            cookie('CART_INFO',$cart,604800);
        }
        //引入视图
        $this->success('添加成功',U('flow1'));
    }
    public function flow1(){
        //验证用户是否已登录
        $this->assign($this->_model->getCartList());
        $this->display();
    }
    public function flow2(){
        if (!$user = session('USER_INFO')) {
            cookie('referer',__SELF__);
            $this->error('先登录，后付款！',U('Member/login'));
        }
        $addresses = D('Address')->getList();
        $this->assign('addresses',$addresses);
        $this->assign($this->_model->getCartList());
        $this->display();
    }

    public function changeAmount($goods_id, $amount){
        if ($user = session('USER_INFO')) {

        }else{
            $cart = cookie('CART_INFO');
            if ($amount == 0) {
                unset($cart[$goods_id]);
            } else {
                $cart[$goods_id] = $amount;
            }
            //将数据保存到cookie中
            cookie('CART_INFO', $cart, 604800);
        }
        $this->success('修改成功');
    }
}