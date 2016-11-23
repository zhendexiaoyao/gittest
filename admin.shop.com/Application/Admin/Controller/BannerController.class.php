<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/23
 * Time: 11:24
 */

namespace Admin\Controller;


use Think\Controller;

class BannerController extends Controller
{
    private $_model;
    public function _initialize() {
        $this->_model = D('Banner');
    }
    public function index(){
        $cond    = [];
        $keyword ='';
        if(IS_GET) {
            $keyword = trim(I('get.keyword'));
        }
        if($keyword){
            $cond['url'] = ['like','%'.$keyword.'%'];
        }
        $data = $this->_model->getPageList($cond);
        $this->assign('pageBar',$data['pageBar']);
        $this->assign('rows',$data['rows']);
        $this->display();
    }
    public function add(){
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->addBanner() === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('添加成功', U('index'));
        }else{
            $this->display();
        }
    }
    public function remove($id){
        if ($this->_model->delete($id)===false) {
            $this->error(get_error($this->_model));
        }
        $this->success('删除成功',U('index'));
    }
    public function edit($id){
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->updateBanner() === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功',U('index'));
        }else{
           $row = $this->_model->getInfo($id);
            $this->assign('row',$row);
            $this->display('add');
        }

    }
}