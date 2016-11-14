<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/14
 * Time: 15:32
 */

namespace Admin\Model;


use Think\Model;

class RoleModel extends Model
{
    public $_validate = [
        ['name','require','角色名不能为空'],
    ];
    public function getPageList(array $cond = []){
        $total = $this->where($cond)->count();
        $page = new \Think\Page($total, C('PAGE_MODE.SIZE'));
        $page->setConfig('theme', C('PAGE_MODE.THEME'));
        $pageBar = $page->show();
        $rows = $this->where($cond)->order('sort')->page($_GET['p'], C('PAGE_MODE.SIZE'))->select();
        return $data = [
            'pageBar' => $pageBar,
            'rows' => $rows
        ];
    }
    public function addRole(){
        $this->startTrans();
        $role_id = $this->add();
        if ($role_id === false) {
            $this->error = '角色插入失败';
            $this->rollback();
            return false;
        }
        $permission_id = I('post.permission_id');
        if (empty($permission_id)) {
            $this->commit();
            return true;
        }
        $data = [];
        foreach($permission_id as $val){
            $data[] = ['role_id'=>$role_id,'permission_id'=>$val];
        }
        if (M('RolePermission')->addAll($data)===false) {
            $this->error = '角色、权限关联失败';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
    public function getRole($id){
        $row = $this->where(['id'=>$id])->find();
        $row['permission_ids'] =json_encode(M('RolePermission')->where(['role_id'=>$id])->getField('permission_id',true)) ;
        return $row;
    }
    public function saveRole(){
        $this->startTrans();
        $role_id = $this->data['id'];
        if ($this->save()===false) {
            $this->rollback();
            return false;
        }
        if (M('RolePermission')->where(['role_id'=>$role_id])->delete()===false) {
            $this->error = '删除角色权限关联失败';
            $this->rollback();
            return false;
        }
        $permission_id = I('post.permission_id');
        if (empty($permission_id)) {
            $this->commit();
            return true;
        }
        $data = [];
        foreach($permission_id as $val){
            $data[] = ['role_id'=>$role_id,'permission_id'=>$val];
        }
        if (M('RolePermission')->addAll($data)===false) {
            $this->error = '角色、权限关联失败';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;

    }
    public function deleteRole($id){
        $this->startTrans();
        if ($this->delete($id)===false) {
            $this->rollback();
            $this->error = '删除角色失败！';
            return false;
        }
        if (M('RolePermission')->where(['role_id'=>$id])->delete()===false) {
            $this->rollback();
            $this->error = '删除角色权限关联失败！';
            return false;
        }
        $this->commit();
        return true;
    }
    public function getRoleList(){
        $rows = $this->order('sort')->select();
        return json_encode($rows);
    }
}