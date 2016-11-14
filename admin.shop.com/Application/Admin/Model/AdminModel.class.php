<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/10
 * Time: 14:30
 */

namespace Admin\Model;


use Think\Model;


class AdminModel extends Model
{
    public $_validate = [
        ['username','require','用户名不能为空'],
        ['username', '', '管理员名称已被占用', '', 'unique',5],
        ['password','require','密码不能为空'],
        ['password', '6,16', '密码长度不合法', '', 'length'],
        ['repassword', 'password', '两次密码不一致', '', 'confirm'],
        ['email', 'require', '邮箱不能为空'],
        ['email', 'email', '邮箱不合法'],
        ['email', '', '邮箱已被占用', '', 'unique', 5],
    ];
    protected $patchValidate = true;
    protected $_auto     = [
        ['add_time', NOW_TIME, 5],
        ['salt', '\Org\Util\String::randString', 5, 'function'],
    ];
    public function checkLogin(){
        $user_name = $this->data['username'];
        $password = $this->data['password'];
        $row = $this->where(['username'=>$user_name])->find();
        if ($row ==false) {
            $this->error = '用户名不存在！';
            return false;
        }
        if (md5(md5($password).md5($row['salt'])) != $row['password']) {
            $this->error = '密码错误！';
            return false;
        }

        return $row;
    }
    public function addAdmin(){
        $this->startTrans();
        $this->data['password'] = md5(md5($this->data['password']).md5($this->data['salt']));
        $admin_id = $this->add();
        if ($admin_id === false) {
            $this->error = '管理员插入失败';
            $this->rollback();
            return false;
        }
        $role_id = I('post.role_id');
        if (empty($role_id)) {
            $this->commit();
            return true;
        }
        $data = [];
        foreach($role_id as $val){
            $data[] = ['admin_id'=>$admin_id,'role_id'=>$val];
        }
        if (M('AdminRole')->addAll($data)===false) {
            $this->error = '管理员、角色关联失败';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
    public function saveAdmin(){
        $this->startTrans();
        $admin_id = $this->data['id'];
        if (M('AdminRole')->where(['admin_id'=>$admin_id])->delete()===false) {
            $this->error = '删除管理员角色关联失败';
            $this->rollback();
            return false;
        }
        $role_id = I('post.role_id');
        if (empty($role_id)) {
            $this->commit();
            return true;
        }
        $data = [];
        foreach($role_id as $val){
            $data[] = ['admin_id'=>$admin_id,'role_id'=>$val];
        }
        if (M('AdminRole')->addAll($data)===false) {
            $this->error = '管理员、角色关联失败';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
    public function getPageList(array $cond = []){
        $total = $this->where($cond)->count();
        if(!$total){
            echo $this->getError();
        }
        $page = new \Think\Page($total,C('PAGE_MODE.SIZE'));
        $page->setConfig('theme', C('PAGE_MODE.THEME'));
        $pageBar = $page->show();
        $rows = $this->where($cond)->page($_GET['p'],C('PAGE_MODE.SIZE'))->select();
        $data = ['pageBar'=>$pageBar,'rows'=>$rows];
        return $data;
    }
    public function autoLogin() {
        $cookie = cookie('TOKEN');
        if(empty($cookie)){
            return [];
        }
        if($admin_info = $this->where($cookie)->where(['token'=>['neq','']])->find()){
            $this->saveToken($admin_info,true);
            session('ADMIN_INFO', $admin_info);
            return $admin_info;
        }else{
            return [];
        }
    }
    public function saveToken($admin_info,$is_remember=false) {
        if($is_remember){
            $token = \Org\Util\String::randString(32);
            $data  = [
                'id'    => $admin_info['id'],
                'token' => $token,
            ];
            cookie('TOKEN', $data, 604800);
            $this->save($data);
        }
    }
    public function getAdmin($id){
        $row = $this->where(['id'=>$id])->find();
        $row['role_ids'] =json_encode(M('AdminRole')->where(['admin_id'=>$id])->getField('role_id',true)) ;
        return $row;
    }
    public function deleteAdmin($id){
        $this->startTrans();
        if ($this->delete($id)===false) {
            $this->rollback();
            $this->error = '删除管理员失败！';
            return false;
        }
        if (M('AdminRole')->where(['admin_id'=>$id])->delete()===false) {
            $this->rollback();
            $this->error = '删除管理员角色关联失败！';
            return false;
        }
        $this->commit();
        return true;
    }
}