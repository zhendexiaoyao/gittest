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
    public function getList(){
        return $this->order('lft')->select();
    }
    public function getMenu($id){
        $row = $this->find($id);
        $permission_ids = M('MenuPermission')->where(['menu_id'=>$id])->getField('permission_id',true);
        $row['permission_ids'] = json_encode($permission_ids);
        return $row;
    }
    public function addMenu(){
        $this->startTrans();
        $db_mysql        = new \Admin\Logic\MysqlOrm();
        $NestedSets = new \Admin\Logic\NestedSets($db_mysql, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');

        unset($this->data['id']);
        $menu_id = $NestedSets->insert($this->data['parent_id'], $this->data, 'bottom');
        if ($menu_id == false) {
            $this->error = '菜单插入失败！';
            $this->rollback();
            return false;
        }
        $permission_ids = I('post.permission_id');
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
    public function saveMenu($id){
        $this->startTrans();

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
        if ($this->save() === false) {
            $this->error = '菜单更新数据失败';
            $this->rollback();
            return false;
        }
        if (M('MenuPermission')->where(['menu_id' => $id])->delete() === false) {
            $this->error = '删除菜单权限关联失败！';
            $this->rollback();
            return false;
        }
        $permission_ids = I('post.permission_id');
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
    public function deleteMenu($id){
        $this->startTrans();
        $db_mysql        = new \Admin\Logic\MysqlOrm();
        $NestedSets = new \Admin\Logic\NestedSets($db_mysql, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
        if ($NestedSets->delete($id) === false) {
            $this->error = '删除失败';
            $this->rollback();
            return false;
        }
        if (M('MenuPermission')->where(['menu_id' => $id])->delete() === false) {
            $this->error = '删除菜单权限关联失败！';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
    public function getVisableMenu() {
        //SELECT DISTINCT m.id,m.`name`,m.`path`,m.`parent_id` FROM shop_menu_permission AS mp JOIN shop_menu AS m ON m.`id`=mp.`menu_id` WHERE permission_id IN(1,2,3,4,5,6)
        $admin_info = session('ADMIN_INFO');
        if($admin_info['username'] != 'admin'){
            //获取权限列表
            $pids = session('ADMIN_PIDS');
            return $this->distinct(true)->field('m.id,m.name,m.path,m.parent_id')->alias('m')->join('__MENU_PERMISSION__ as mp ON m.`id`=mp.`menu_id`')->where(['permission_id'=>['in',$pids]])->select();
        }else{
            return $this->distinct(true)->field('m.id,m.name,m.path,m.parent_id')->alias('m')->select();
        }

    }
}