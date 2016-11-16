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

    /**
     * 权限列表
     */
    public function index(){
        //按左节点进行排序
        $rows = $this->_model->order('lft')->select();
        $this->assign('rows',$rows);
        $this->display();
    }

    /**
     * 添加权限
     */
    public function add(){
        if (IS_POST) {
            //收集数据
            if ($this->_model->create()===false) {
                $this->error(get_error($this->_model));
            }
            //添加权限
            if ($this->_model->addPermission()===false) {
                $this->error(get_error($this->_model));
            }
            //跳转
                $this->success('添加成功',U('index'));
        }else{
            //获得含有顶级权限的权限列表
            $permission = $this->_model->getPermission();
            $this->assign('permission',$permission);
            $this->display();
        }
    }

    /**
     * 编辑权限
     * @param $id
     */
    public function edit($id){
        if (IS_POST) {
            //收集数据
            if ($this->_model->create()===false) {
                $this->error(get_error($this->_model));
            }
            //修改数据
            if ($this->_model->savePermission($id)===false) {
                $this->error(get_error($this->_model));
            }
            //跳转
            $this->success('修改成功',U('index'));

        }else{
            //获得当前权限的基本信息
            $rs = $this->_model->find($id);
            $this->assign('rs',$rs);
            $permission = $this->_model->getPermission();
            $this->assign('permission',$permission);
            $this->display('add');
        }
    }

    /**
     * 删除权限
     * @param $id
     */
    public function remove($id){
        if ($this->_model->deletePermission($id)===false) {
            $this->error(get_error($this->_model));
        }
            $this->success('删除成功',U('index'));
    }
}