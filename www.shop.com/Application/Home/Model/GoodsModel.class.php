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
     * ע����������д��
     * @param $goods_status
     * @return mixed
     */
    public function getGoodsByStatus($goods_status){
        return $this->where('goods_status &'.$goods_status)->order('sort')->select();
    }
    public function getGoodsInfo($id) {
        $row = $this->where(['status'=>1,'is_on_sale'=>1])->find($id);
        $row['brand_name'] = M('Brand')->where(['id'=>$row['brand_id']])->getField('name');
        //��ȡ��Ʒ����
        $row['content']=M('GoodsDetail')->where(['goods_id'=>$row['id']])->getField('content');
        //��ȡ��Ʒ���
        $row['gallery']=M('GoodsGallery')->where(['goods_id'=>$row['id']])->getField('path',true);
        return $row;
    }

    /**
     * ���ݹ��ﳵ����Ʒid�����ϸ��Ϣ
     * @param array $goods_ids
     * @return mixed
     */
    public function getGoodsByGoodsIds(array $goods_ids) {
        return $this->where(['id'=>['in',$goods_ids],'status'=>1,'is_on_sale'=>1])->getField('id,name,logo,shop_price');
    }
}