<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/14
 * Time: 12:55
 */

namespace Admin\Model;


use Think\Model;

class PermissionModel extends Model
{
    public $_validate = [
        ['name','require','权限名不能为空'],
        ['parent_id','require','父级权限不能为空'],
    ];
    protected $patchValidate = true;
    public function getPermission(){
        $permission = $this->order('lft')->select();
        array_unshift($permission,['id'=>0,'name'=>'顶级权限']);
        return json_encode($permission);
    }
    public function addPermission(){
        $db_mysql        = new \Admin\Logic\MysqlOrm();
        $NestedSets = new \Admin\Logic\NestedSets($db_mysql, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');

        unset($this->data['id']);
        return $NestedSets->insert($this->data['parent_id'], $this->data, 'bottom');
    }
    public function savePermission($id){
        $old_parent_id = $this->where(['id'=>$id])->getField('parent_id');
        if ($old_parent_id != $this->data['parent_id']) {
            $db_mysql        = new \Admin\Logic\MysqlOrm();
            $NestedSets = new \Admin\Logic\NestedSets($db_mysql, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
            if ($NestedSets->moveUnder($this->data['id'], $this->data['parent_id'], 'bottom') === false) {
                $this->error = '不能将分类移动到后代分类中';
                return false;
            }
        }
        return $this->save();
    }

    public function deletePermission($id){
        $this->startTrans();
        $db_mysql        = new \Admin\Logic\MysqlOrm();
        $NestedSets = new \Admin\Logic\NestedSets($db_mysql, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
        if ($NestedSets->delete($id) === false) {
            $this->error = '删除失败';
            $this->rollback();
            return false;
        }
        $rs = M('RolePermission')->where(['permission_id'=>$id])->delete();
        if ($rs === false) {
            $this->error = '删除角色权限关联失败';
            $this->rollback();
            return false;
        }
        $result = M('MenuPermission')->where(['permission_id'=>$id])->delete();
        if ($result === false) {
            $this->error = '删除菜单权限关联失败';
            $this->rollback();
            return false;
        }
        return true;
    }
}