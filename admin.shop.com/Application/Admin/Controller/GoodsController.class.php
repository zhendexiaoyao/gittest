<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/9
 * Time: 10:06
 */

namespace Admin\Controller;


use Think\Controller;

class GoodsController extends Controller
{
    private $_model;
    public function _initialize() {
        $this->_model = D('Goods');
    }
    public function index(){
        //搜索
        $cond    = [];
        $keyword ='';
        if(IS_GET){
            $keyword = trim(I('get.keyword'));
            $goods_category_id = I('get.goods_category_id');
            $brand_id = I('get.brand_id');
            $goods_status = I('get.goods_status');
            $is_on_sale = I('get.is_on_sale');

        }
        if($keyword){
            $cond['shop_article.name'] = ['like','%'.$keyword.'%'];
        }
        if($goods_category_id){
            $cond['goods_category_id'] = $goods_category_id;
        }
        if($brand_id){
            $cond['brand_id'] = $brand_id;
        }
        if($goods_status){
            $cond['goods_status'] = $goods_status;
        }if($is_on_sale){
            $cond['is_on_sale'] = $is_on_sale;
        }


        $data = $this->_model->getPageList($cond);
        $this->assign('pageBar',$data['pageBar']);
        $this->assign('rows',$data['rows']);
        //获得所有产品分类
        $this->_category();
        //获得所有品牌
        $this->_brands();
        $this->display();
    }

    /**
     * 产品添加
     */
    public function add(){
        if (IS_POST) {
            $path = I('post.path');
            //编辑器的数据取消掉过滤
            $content = I('post.content','',false);
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->addGoods($path,$content) === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('添加成功', U('index'));

        }else{
            $this->_categories();
            $this->_brands();
            $this->display();
        }

    }

    /**
     * 删除产品
     * @param $id
     */
    public function remove($id){
        //采用逻辑删除，只是改变产品状态
        $rs = $this->_model->where(['id'=>$id])->setField('status',-1);
        if($rs){
            $this->success('删除成功',U('index'));
        }else{
            $this->error('删除失败');
        }
    }

    /**
     * 编辑产品
     * @param $id
     */
    public function edit($id){
        if (IS_POST) {
            $path = I('post.path');
            $content = I('post.content','',false);
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->updateGoods($path,$content) === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功',U('index'));
        }else{
            $row = $this->_model->requestData($id);
            $this->assign('row',$row);
            $this->_categories();
            $this->_brands();
            $this->display('add');
        }
    }
    //获得添加时，需要的分类json信息
    private function _categories() {
        $rows = D('GoodsCategory')->order('lft')->select();
        array_unshift($rows, ['id' => 0, 'name' => '顶级分类']);
        $categories = json_encode($rows);
        $this->assign('categories', $categories);
    }
    //获得数据库中有的分类信息
    private function _category() {
        $categories = D('GoodsCategory')->order('lft')->select();
        $this->assign('categories', $categories);
    }
    //获得品牌信息
    private function _brands() {
        $brands = D('Brand')->field('id,name')->select();
        $this->assign('brands', $brands);
    }
}