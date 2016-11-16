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

    /**
     * 分页信息
     * @param array $cond
     * @return array
     */
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

    /**
     * 添加角色
     * @return bool
     */
    public function addRole(){
        $this->startTrans();
        $role_id = $this->add();
        //插入角色基本信息
        if ($role_id === false) {
            $this->error = '角色插入失败';
            $this->rollback();
            return false;
        }
        //获取角色关联的权限信息
        $permission_id = I('post.permission_id');
        //允许角色权限为空
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
    //获得指定id角色的所有信息包括关联的权限id
    public function getRole($id){
        $row = $this->where(['id'=>$id])->find();
        $row['permission_ids'] =json_encode(M('RolePermission')->where(['role_id'=>$id])->getField('permission_id',true)) ;
        return $row;
    }
    //修改角色信息
    public function saveRole(){
        $this->startTrans();
        $role_id = $this->data['id'];
        //先修改基本信息
        if ($this->save()===false) {
            $this->rollback();
            return false;
        }
        //删除与旧权限的关联
        if (M('RolePermission')->where(['role_id'=>$role_id])->delete()===false) {
            $this->error = '删除角色权限关联失败';
            $this->rollback();
            return false;
        }
        //添加新的关联
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
    //删除角色
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
    //获取所有权限的json信息
    public function getRoleList(){
        $rows = $this->order('sort')->select();
        return json_encode($rows);
    }
}