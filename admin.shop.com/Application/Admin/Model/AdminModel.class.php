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
    protected $patchValidate = true;//批量验证
    protected $_auto     = [
        ['add_time', NOW_TIME, 5],//当前时间
        ['salt', '\Org\Util\String::randString', 5, 'function'],//获取六位随机字符串
    ];

    /**
     * 验证登录
     * @return bool|mixed
     */
    public function checkLogin(){
        //获得输入的用户名密码
        $user_name = $this->data['username'];
        $password = $this->data['password'];
        //验证是否存在当前用户名
        $row = $this->where(['username'=>$user_name])->find();
        if ($row ==false) {
            $this->error = '用户名不存在！';
            return false;
        }
        //验证用户的密码是否正确
        if (md5(md5($password).md5($row['salt'])) != $row['password']) {
            $this->error = '密码错误！';
            return false;
        }

        return $row;
    }

    /**
     * 添加管理员的方法
     * @return bool
     */
    public function addAdmin(){
        $this->startTrans();
        //对密码进行处理，避免存入明文密码
        $this->data['password'] = md5(md5($this->data['password']).md5($this->data['salt']));
        $admin_id = $this->add();
        if ($admin_id === false) {
            $this->error = '管理员插入失败';
            $this->rollback();
            return false;
        }
        //获得该管理员名下的角色信息
        $role_id = I('post.role_id');
        //可能该用户并没有角色信息
        if (empty($role_id)) {
            $this->commit();
            return true;
        }
        $data = [];
        foreach($role_id as $val){
            $data[] = ['admin_id'=>$admin_id,'role_id'=>$val];
        }
        //将该管理员的角色信息添加到数据库中
        if (M('AdminRole')->addAll($data)===false) {
            $this->error = '管理员、角色关联失败';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    /**
     * 修改管理员信息
     * @return bool
     */
    public function saveAdmin(){
        $this->startTrans();
        $admin_id = $this->data['id'];
        //根据管理员id，删除管理员角色关联信息
        if (M('AdminRole')->where(['admin_id'=>$admin_id])->delete()===false) {
            $this->error = '删除管理员角色关联失败';
            $this->rollback();
            return false;
        }
        //获取修改后的管理员角色id
        $role_id = I('post.role_id');
        if (empty($role_id)) {
            $this->commit();
            return true;
        }
        $data = [];
        foreach($role_id as $val){
            $data[] = ['admin_id'=>$admin_id,'role_id'=>$val];
        }
        //将处理后的数据插入管理员角色关联表
        if (M('AdminRole')->addAll($data)===false) {
            $this->error = '管理员、角色关联失败';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    /**
     * 获得分页数据
     * @param array $cond
     * @return array
     */
    public function getPageList(array $cond = []){
        //带条件获取管理员数
        $total = $this->where($cond)->count();
        if(!$total){
            echo $this->getError();
        }
        $page = new \Think\Page($total,C('PAGE_MODE.SIZE'));
        //配置分页条显示信息
        $page->setConfig('theme', C('PAGE_MODE.THEME'));
        //显示分页条信息
        $pageBar = $page->show();
        //获取分页数据
        $rows = $this->where($cond)->page($_GET['p'],C('PAGE_MODE.SIZE'))->select();
        $data = ['pageBar'=>$pageBar,'rows'=>$rows];
        return $data;
    }

    /**
     * 自动登录
     * @return array|mixed
     */
    public function autoLogin() {
        //验证cookie里面是否保存有值
        $cookie = cookie('TOKEN');
        if(empty($cookie)){
            return [];
        }
        //根据保存的cookie取得用户信息，过滤掉token为空的情况
        if($admin_info = $this->where($cookie)->where(['token'=>['neq','']])->find()){
            //更新token
            $this->saveToken($admin_info,true);
            //将信息重新存入session
            session('ADMIN_INFO', $admin_info);
            $this->savePath();
            return $admin_info;
        }else{
            return [];
        }
    }

    /**
     * 取得token
     * @param $admin_info
     * @param bool|false $is_remember
     */
    public function saveToken($admin_info,$is_remember=false) {
        if($is_remember){
            $token = \Org\Util\String::randString(32);
            $data  = [
                'id'    => $admin_info['id'],
                'token' => $token,
            ];
            //将ctoken存入数据库和cookie
            cookie('TOKEN', $data, 604800);
            $this->save($data);
        }
    }

    /**
     * 获得当前管理员信息
     * @param $id
     * @return mixed
     */
    public function getAdmin($id){
        $row = $this->where(['id'=>$id])->find();
        $row['role_ids'] =json_encode(M('AdminRole')->where(['admin_id'=>$id])->getField('role_id',true)) ;
        return $row;
    }

    /**
     * 删除管理员方法
     * @param $id
     * @return bool
     */
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

    /**
     * 获得当前管理员名下的权限路径和id
     */
    public function savePath(){
        $admininfo = session('ADMIN_INFO');
        $id = $admininfo['id'];
        $path = M('AdminRole')->alias('ar')->field('p.id,path')->join('__ROLE_PERMISSION__ as rp using(`role_id`)')->join('__PERMISSION__ as p ON rp.`permission_id`=p.`id`')->where(['ar.admin_id'=>$id])->select();
        $pathes = $permission_ids = [];
        foreach($path as $val){
            $pathes[] = $val['path'];
            $permission_ids[] = $val['id'];
        }
        session('ADMIN_PATH',$pathes);
        session('ADMIN_PIDS',$permission_ids);
    }
}