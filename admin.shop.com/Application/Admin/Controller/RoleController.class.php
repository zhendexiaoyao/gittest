<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/13
 * Time: 11:50
 */

namespace Admin\Controller;


use Think\Controller;

class RoleController extends Controller
{
    private $_model;
    protected function _initialize(){
        $this->_model = D('Role');
    }

    /**
     * 角色列表
     */
    public function index(){
        $cond    = [];
        $keyword ='';
        if(IS_GET){
            $keyword = trim(I('get.keyword'));
        }
        if($keyword){
            $cond['name'] = ['like','%'.$keyword.'%'];
        }
        $data = $this->_model->getPageList($cond);
        $this->assign('pageBar',$data['pageBar']);
        $this->assign('rows',$data['rows']);
        $this->display();
    }

    /**
     * 添加角色
     */
    public function add(){
        if (IS_POST) {
            if ($this->_model->create()===false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->addRole()===false) {
                $this->error(get_error($this->_model));
            }
            $this->success('添加成功',U('index'));
        }else{
            $this->_get_permission();
            $this->display();
        }
    }

    /**
     * 编辑角色
     * @param $id
     */
    public function edit($id){
        if (IS_POST) {
            if ($this->_model->create()===false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->saveRole()===false) {
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功',U('index'));
        }else{
            $row = $this->_model->getRole($id);
            $this->assign('row',$row);
            $this->_get_permission();
            $this->display('add');
        }
    }

    /**
     * 删除角色
     * @param $id
     */
    public function remove($id){
        if ($this->_model->deleteRole($id)===false) {
            $this->error(get_error($this->_model));
        }
        $this->success('删除成功',U('index'));
    }

    /**
     * 获得前台z-tree需要的权限json信息
     */
    private function _get_permission(){
        $permission = M('Permission')->order('lft')->select();
        $this->assign('permission',json_encode($permission));
    }
}