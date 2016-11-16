<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/10
 * Time: 14:22
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Verify;

class AdminController extends Controller
{
    /**
     * 管理员登录
     */
    public function login(){
        if (IS_POST) {
            $admin_model = D('Admin');//实例化model
            //收集数据，自动验证自动完成
            if ($admin_model->create() == false) {
                $this->error(get_error($admin_model));
            }
            //获得用户提交的验证码数据
            $code = I('post.code');
            //实例化验证码工具类，验证验证码输入是否正确
            $verify = new Verify();
            if ($verify->check($code) == false) {
                $this->error('验证码错误');
                return;
            }
            //验证用户名密码是否正确，正确就返回用户数据，错误返回false
            $row = $admin_model->checkLogin();
//            dump($row);exit;
            if ($row === false) {
                $this->error($admin_model->getError());
            }
            //将用户登陆的事件和ip存入用户数据中
            $row['last_login_time'] = time();
            $row['last_login_ip'] = get_client_ip(1);
            //将用户信息更新到数据库
            $admin_model->save($row);
            //登陆成功后将数据存入session
            session('ADMIN_INFO',$row);
            //将该用户对应的权限路径和权限id存入session
            $admin_model->savePath();
            //根据是否勾选记住密码，设置token并记入数据库和cookie中
            $admin_model->saveToken($row,I('post.remember'));
            $this->success('登录成功！', U('Admin/Index/index'));
        }else{
            $this->display();
        }
    }
    public function verify()
    {
        //验证码工具配置项
        $config = array(
            'length'    => 4,
            'fontSize'  => 15,
            'useCurve'  =>false,
        );
        $captcha = new Verify($config);
        //展示验证码
        $captcha->entry();
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        cookie(null);
        session(null);
        $this->success('退出成功',U('Index/index'));
    }

    /**
     * 添加管理员
     */
    public function add(){
        $admin_model = D('Admin');
        if (IS_POST) {
            //状态为5的收集数据，自动验证时除了其他默认的状态值为5的也要验证自动完成是只有状态5才完成
            if ($admin_model->create('',5) === false) {
                $this->error(get_error($admin_model));
            }
            if ($admin_model->addAdmin() === false) {
                $this->error(get_error($admin_model));
            }
            $this->success('添加成功', U('index'));
        }else{
            //获得角色的列表
            $this->_role_ztree();
            $this->display();
        }
    }

    /**
     * 管理员列表
     */
    public function index(){
        $cond    = [];
        $keyword ='';
        if(IS_GET){
            //将关键词两边的空格去掉
            $keyword = trim(I('get.keyword'));
        }
        //有关键词时构建条件
        if($keyword){
            $cond['username'] = ['like','%'.$keyword.'%'];
        }

        $admin_model = D('Admin');
        //获得分页数据
        $data = $admin_model->getPageList($cond);
        $this->assign('pageBar',$data['pageBar']);
        $this->assign('rows',$data['rows']);
        $this->display();
    }

    /**
     * 编辑管理员
     * @param $id
     */
    public function edit($id) {
        $admin_model = D('Admin');
        if (IS_POST) {
            //获取数据
            if ($admin_model->create() === false) {
                $this->error(get_error($admin_model));
            }
            //修改数据
            if ($admin_model->saveAdmin() === false) {
                $this->error(get_error($admin_model));
            }
            $this->success('修改成功', U('index'));
        } else {
            $this->_role_ztree();
            //获取修改管理员的数据和管理员拥有的角色id并绑定页面
            $row = $admin_model->getAdmin($id);
            $this->assign('row', $row);
            $this->display('add');
        }
    }

    /**
     * 删除管理员
     * @param $id
     */
    public function remove($id) {
        $admin_model = D('Admin');
        if ($admin_model->deleteAdmin($id) === false) {
            $this->error(get_error($admin_model));
        }
        $this->success('删除成功', U('index'));
    }

    /**
     * 获得角色的json字符串
     */
    private function _role_ztree(){
        $roles = D('Role')->getRoleList();
        $this->assign('roles',$roles);
    }

}