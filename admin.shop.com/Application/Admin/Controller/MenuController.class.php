<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/15
 * Time: 19:02
 */

namespace Admin\Controller;


use Think\Controller;

class MenuController extends Controller
{
    /**
     * @var \Admin\Model\MenuModel
     */
    private $_model = null;
    //写在Controller里构造方法里面的一个初始方法，new 控制器时就会执行
    protected function _initialize(){
        $this->_model = D('Menu');
    }

    /**
     * 菜单列表
     */
    public function index(){
        $rows = $this->_model->getList();
        $this->assign('rows', $rows);
        $this->display();
    }

    /**
     * 添加菜单
     */
    public function add(){
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->addMenu() === false) {
                $this->error(get_error($this->_model));
            }
                $this->success('添加成功',U('index'));
        }else{
            //获得所有菜单项和权限项
            $this->_before_view();
            $this->display();
        }
    }

    /**
     * 编辑菜单
     * @param $id
     */
    public function edit($id){
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->saveMenu($id) === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功',U('index'));
        }else{
            $this->_before_view();
            //获得当前菜单的回显数据
            $row = $this->_model->getMenu($id);
            $this->assign('row', $row);
            $this->display('add');
        }
    }

    /**
     * 移除菜单
     * @param $id
     */
    public function remove($id){
        if ($this->_model->deleteMenu($id) === false) {
            $this->error(get_error($this->_model));
        } else {
            $this->success('删除成功', U('index'));
        }
    }
    private function _before_view(){
        //获得所有菜单项，好设置父级菜单
        $row = $this->_model->getList();
        array_unshift($row,['id'=>0,'name'=>'顶级菜单']);

        $this->assign('menus',json_encode($row));
        //获得所有权限，准备关联菜单和权限
        $permissions = M('Permission')->order('lft')->select();
        $this->assign('permissions', json_encode($permissions));

    }
}