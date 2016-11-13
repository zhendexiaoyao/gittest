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
    public function login(){
        if (IS_POST) {
            $admin_model = D('Admin');
            if ($admin_model->create() == false) {
                $this->error(get_error($admin_model));
            }
            $code = I('post.code');
            $verify = new Verify();
            if ($verify->check($code) == false) {
                $this->error('验证码错误');
                return;
            }
            $row = $admin_model->checkLogin();
//            dump($row);exit;
            if ($row === false) {
                $this->error($admin_model->getError());
            }
            $row['last_login_time'] = time();
            $row['last_login_ip'] = get_client_ip(1);
            $admin_model->save($row);
            session('ADMIN_INFO',$row);
            $admin_model->saveToken($row,I('post.remember'));
            $this->success('登录成功！', U('index'));
        }else{
            $this->display();
        }
    }
    public function verify()
    {
        $config = array(
            'length'    => 4,
            'fontSize'  => 15,
            'useCurve'  =>false,
        );
        $captcha = new Verify($config);
        $verify = $captcha->entry();
        dump($verify);
    }
    public function logout()
    {
        cookie(null);
        session('userinfo',null);
        $this->success('退出成功',U('login'));
    }
    public function add(){
        $admin_model = D('Admin');
        if (IS_POST) {
            if ($admin_model->create('',5) === false) {
                $this->error(get_error($admin_model));
            }
            if ($admin_model->addAdmin() === false) {
                $this->error(get_error($admin_model));
            }
            $this->success('添加成功', U('index'));
        }else{
            $this->display();
        }
    }
    public function index(){
        $cond    = [];
        $keyword ='';
        if(IS_GET){
            $keyword = trim(I('get.keyword'));
        }
        if($keyword){
            $cond['username'] = ['like','%'.$keyword.'%'];
        }

        $admin_model = D('Admin');
        $data = $admin_model->getPageList($cond);
        $this->assign('pageBar',$data['pageBar']);
        $this->assign('rows',$data['rows']);
        $this->display();
    }
    public function edit($id) {
        if (IS_POST) {

            $this->success('修改成功', U('index'));
        } else {
            $row = D('Admin')->find($id);
            $this->assign('row', $row);
            $this->display('add');
        }
    }
    public function remove($id) {
        $admin_model = D('Admin');
        if ($admin_model->delete($id) === false) {
            $this->error(get_error($admin_model));
        }
        $this->success('删除成功', U('index'));
    }

}