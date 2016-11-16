<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/15
 * Time: 19:21
 */

namespace Admin\Model;


use Think\Model;

class MenuModel extends Model
{
    /**
     * 按左节点排序获得的菜单列表
     * @return mixed
     */
    public function getList(){
        return $this->order('lft')->select();
    }

    /**
     * 获得指定id菜单项的基本数据和关联的权限id
     * @param $id
     * @return mixed
     */
    public function getMenu($id){
        $row = $this->find($id);
        $permission_ids = M('MenuPermission')->where(['menu_id'=>$id])->getField('permission_id',true);
        $row['permission_ids'] = json_encode($permission_ids);
        return $row;
    }

    /**
     * 添加菜单
     * @return bool
     */
    public function addMenu(){
        $this->startTrans();
        $db_mysql        = new \Admin\Logic\MysqlOrm();
        $NestedSets = new \Admin\Logic\NestedSets($db_mysql, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');

        unset($this->data['id']);
        //添加节点
        $menu_id = $NestedSets->insert($this->data['parent_id'], $this->data, 'bottom');
        if ($menu_id == false) {
            $this->error = '菜单插入失败！';
            $this->rollback();
            return false;
        }
        //添加相关联的权限id
        $permission_ids = I('post.permission_id');
        //允许有菜单没有关联权限
        if(empty($permission_ids)){
            $this->commit();
            return true;
        }
        $data = [];
        foreach($permission_ids as $val){
            $data[] = ['menu_id' => $menu_id,'permission_id'=>$val];
        }
        $rs = M('MenuPermission')->addAll($data);
        if ($rs ===false) {
            $this->error = '菜单权限关联插入失败！';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    /**
     * 修改菜单
     * @param $id
     * @return bool
     */
    public function saveMenu($id){
        $this->startTrans();
        //比较两次菜单的parent_id有没有发生变化
        $old_parent_id = $this->where(['id' => $id])->getField('parent_id');
        if ($old_parent_id != $this->data['parent_id']) {
            $db_mysql        = new \Admin\Logic\MysqlOrm();
            $NestedSets = new \Admin\Logic\NestedSets($db_mysql, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
            if ($NestedSets->moveUnder($this->data['id'], $this->data['parent_id'], 'bottom') === false) {
                $this->error = '不能将分类移动到后代分类中';
                $this->rollback();
                return false;
            }
        }
        //修改菜单基本信息
        if ($this->save() === false) {
            $this->error = '菜单更新数据失败';
            $this->rollback();
            return false;
        }
        //删除原来的菜单权限关联
        if (M('MenuPermission')->where(['menu_id' => $id])->delete() === false) {
            $this->error = '删除菜单权限关联失败！';
            $this->rollback();
            return false;
        }
        //添加新的菜单权限关联
        $permission_ids = I('post.permission_id');
        //允许菜单关联的权限为空
        if(empty($permission_ids)){
            $this->commit();
            return true;
        }
        $data = [];
        foreach($permission_ids as $val){
            $data[] = ['menu_id' => $id,'permission_id'=>$val];
        }
        $rs = M('MenuPermission')->addAll($data);
        if ($rs ===false) {
            $this->error = '菜单权限关联插入失败！';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    /**
     * 删除菜单
     * @param $id
     * @return bool
     */
    public function deleteMenu($id){
        $this->startTrans();
        $db_mysql        = new \Admin\Logic\MysqlOrm();
        $NestedSets = new \Admin\Logic\NestedSets($db_mysql, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
        if ($NestedSets->delete($id) === false) {
            $this->error = '删除失败';
            $this->rollback();
            return false;
        }
        //删除菜单权限关联
        if (M('MenuPermission')->where(['menu_id' => $id])->delete() === false) {
            $this->error = '删除菜单权限关联失败！';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    /**
     * 获得能看见的菜单项
     * @return mixed
     */
    public function getVisableMenu() {
        //SELECT DISTINCT m.id,m.`name`,m.`path`,m.`parent_id` FROM shop_menu_permission AS mp JOIN shop_menu AS m ON m.`id`=mp.`menu_id` WHERE permission_id IN(1,2,3,4,5,6)
        $admin_info = session('ADMIN_INFO');
        //从用户登录信息里获取该用户拥有的所有权限id，如果是超级管理员则拥有所有菜单项
        if($admin_info['username'] != 'admin'){
            //获取权限列表
            $pids = session('ADMIN_PIDS');
            //根据权限id，获得能显示的菜单项
            return $this->distinct(true)->field('m.id,m.name,m.path,m.parent_id')->alias('m')->join('__MENU_PERMISSION__ as mp ON m.`id`=mp.`menu_id`')->where(['permission_id'=>['in',$pids]])->select();
        }else{
            return $this->distinct(true)->field('m.id,m.name,m.path,m.parent_id')->alias('m')->select();
        }

    }
}