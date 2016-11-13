<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/9
 * Time: 10:10
 */

namespace Admin\Model;


use Think\Model;

class GoodsModel extends Model
{
    protected $_validate = [
        ['name','require','用户名不能为空'],
        ['logo','require','请上传商品图片'],
    ];
//    protected $patchValidate    =   true;
    protected $_auto = [
        ['inputtime','time',3,'function'],
        ['goods_status','array_sum',3,'function'],
    ];
    public function getPageList(array $cond = []){
        $cond = array_merge(['status'=>['neq',-1]],$cond);
        $total = $this->where($cond)->count();
        if(!$total){
            echo $this->getError();
        }
        $page = new \Think\Page($total,C('PAGE_MODE.SIZE'));
        $page->setConfig('theme', C('PAGE_MODE.THEME'));
        $pageBar = $page->show();
        $rows = $this->where($cond)->order('sort')->page($_GET['p'],C('PAGE_MODE.SIZE'))->select();
        $data = ['pageBar'=>$pageBar,'rows'=>$rows];
        return $data;
    }
    public function requestData($id){
        $row = $this->where(['id'=>$id])->find();
        $goods_status = $row['goods_status'];
        $data = [];
        if ($goods_status & 1) {
            $data[] = 1;
        }
        if ($goods_status & 2) {
            $data[] = 2;
        }
        if ($goods_status & 4) {
            $data[] = 4;
        }
        $row['goods_status'] = json_encode($data);
        //以上是goods表中数据
        $goods_detail = M('GoodsDetail');
        $row['content'] = $goods_detail->getFieldByGoodsId($id,'content');
        //以上是goods_detail表中数据
        $goods_gallery = M('GoodsGallery');//这是获得相册表数据
        $row['path'] = json_encode($goods_gallery->field('path')->where(['goods_id'=>$id])->select());
        return $row;
    }
    private function getSn(){
        $goods_day_count = M('GoodsDayCount');
        $day = date('Ymd');
        $count = $goods_day_count->getFieldByDay($day,'count');
        if(!$count){
            $count = 1;
            $data = ['day'=>$day,'count'=>$count];
            $goods_day_count->add($data);
        }else{
            $count++;
            $data = ['day'=>$day,'count'=>$count];
            $goods_day_count->save($data);
        }
        $cs = '0000'.$count;
        $cs = substr($cs,-5);
        return 'SN'.$day.$cs;
    }
    public function addGoods($path,$content){
        $this->startTrans();
        $goods_detail = M('GoodsDetail');
        $goods_gallery = M('GoodsGallery');
        $goods_id = $this->add();
        if ($goods_id === false) {
            $this->rollback();
            return false;

        }
        $detail = ['goods_id'=>$goods_id,'content'=>$content];
        if ($goods_detail->add($detail) === false) {
            $this->rollback();
            return false;
        }
        $gallery = [];
        foreach($path as $key=>$val){
            $gallery[$key]['path'] = $val;
            $gallery[$key]['goods_id'] = $goods_id;
        }
        if ($goods_gallery->addAll($gallery) === false) {
            $this->rollback();
            return false;
        }
        $sn = $this->getSn();
        if ($this->where(['id'=>$goods_id])->setField('sn',$sn) === false) {
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
    public function updateGoods($path,$content){
        $this->startTrans();
        $goods_detail = M('GoodsDetail');
        $goods_gallery = M('GoodsGallery');
        $goods_id = $this->data['id'];
        $rs = $this->save();
        if ($rs === false) {
            $this->rollback();
            return false;
        }
        $detail = ['goods_id'=>$goods_id,'content'=>$content];
        if ($goods_detail->save($detail) === false) {
            $this->rollback();
            return false;
        }
        $gallery = [];
        foreach($path as $key=>$val){
            $gallery[$key]['path'] = $val;
            $gallery[$key]['goods_id'] = $goods_id;
        }
        $goods_gallery->where(['goods_id'=>$goods_id])->delete();
        if ($goods_gallery->addAll($gallery) === false) {
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
}