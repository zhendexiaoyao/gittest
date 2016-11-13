<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/5
 * Time: 13:29
 */

namespace Admin\Controller;


class BrandController   extends \Think\Controller
{
    public function index(){
        $cond    = [];
        $keyword ='';
        if(IS_GET){
            $keyword = trim(I('get.keyword'));
        }
        if($keyword){
            $cond['name'] = ['like','%'.$keyword.'%'];
        }
        $brand_model = D('Brand');
        $data = $brand_model->getPageList($cond);
        $this->assign('pageBar',$data['pageBar']);
        $this->assign('rows',$data['rows']);
        $this->display();
    }
    public function add(){
        $brand_model = D('Brand');
        if (IS_POST) {
            if($brand_model->create() === false){
                $this->error($brand_model->getError());
            }
            if(!$brand_model->add()){
                $this->error($brand_model->getError());
            }
            $this->success('添加成功',U('index'));
        }else{
            $this->display();
        }
    }
    public function remove($id=0){
        $brand = D('Brand');
        $rs = $brand->where(['id'=>$id])->setField('status',-1);
        if($rs){
            $this->success('删除成功',U('index'));
        }else{
            $this->error('删除失败');
        }
    }
    public function edit($id=0){
        $brand = D('Brand');
        if(IS_POST){
            $rs = $brand->create();
            if(!$rs){
                $this->error($brand->getError());
            }
            if (!$brand->save($rs)) {
                $this->error($brand->getError());
            }
            $this->success('修改成功',U('index'));
        }else{
            $row = $brand->find($id);
            $this->assign('row', $row);
            $this->display('add');
        }
    }

}