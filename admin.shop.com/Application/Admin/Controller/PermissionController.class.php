<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/13
 * Time: 11:53
 */

namespace Admin\Controller;


use Think\Controller;

class PermissionController extends Controller
{
    private $_model;
    protected function _initialize(){
        $this->_model = D('Permission');
    }
    public function index(){
        $rows = $this->_model->order('lft')->select();
        $this->assign('rows',$rows);
        $this->display();
    }
    public function add(){
        if (IS_POST) {
            if ($this->_model->create()===false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->addPermission()===false) {
                $this->error(get_error($this->_model));
            }
                $this->success('添加成功',U('index'));
        }else{
            $permission = $this->_model->getPermission();
            $this->assign('permission',$permission);
            $this->display();
        }
    }
    public function edit($id){
        if (IS_POST) {
            if ($this->_model->create()===false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->savePermission($id)===false) {
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功',U('index'));

        }else{
            $rs = $this->_model->find($id);
            $this->assign('rs',$rs);
            $permission = $this->_model->getPermission();
            $this->assign('permission',$permission);
            $this->display('add');
        }
    }
    public function remove($id){
        if ($this->_model->deletePermission($id)===false) {
            $this->error(get_error($this->_model));
        }
            $this->success('删除成功',U('index'));
    }
}