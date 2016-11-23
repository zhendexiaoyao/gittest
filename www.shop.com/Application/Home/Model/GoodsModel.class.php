<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 12:48
 */

namespace Home\Model;


use Think\Model;

class GoodsModel extends Model
{
    /**
     * 注意条件语句的写法
     * @param $goods_status
     * @return mixed
     */
    public function getGoodsByStatus($goods_status){
        return $this->where('goods_status &'.$goods_status)->order('sort')->select();
    }
    public function getGoodsInfo($id) {
        $row = $this->where(['status'=>1,'is_on_sale'=>1])->find($id);
        $row['brand_name'] = M('Brand')->where(['id'=>$row['brand_id']])->getField('name');
        //获取商品详情
        $row['content']=M('GoodsDetail')->where(['goods_id'=>$row['id']])->getField('content');
        //获取商品相册
        $row['gallery']=M('GoodsGallery')->where(['goods_id'=>$row['id']])->getField('path',true);
        return $row;
    }

    /**
     * 根据购物车中商品id获得详细信息
     * @param array $goods_ids
     * @return mixed
     */
    public function getGoodsByGoodsIds(array $goods_ids) {
        return $this->where(['id'=>['in',$goods_ids],'status'=>1,'is_on_sale'=>1])->getField('id,name,logo,shop_price');
    }
}