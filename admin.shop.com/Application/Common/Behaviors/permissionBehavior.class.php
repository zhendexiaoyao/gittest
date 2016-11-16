<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/12
 * Time: 22:09
 */

namespace Common\Behaviors;


use Think\Behavior;

class permissionBehavior extends Behavior
{
    public function run(&$param) {
        //获取全局的忽略列表
        $ignores = C('RBAC.IGNORES');
        //当前要访问的模型方法
        $url     = MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;
        if (in_array($url, $ignores)) {
            return true;
        }
        $admininfo = session('ADMIN_INFO');
        //没有session则验证自动登录
        if (!$admininfo) {
            if (!D('Admin')->autoLogin()) {
                $url = U('Admin/login');
                redirect($url);
            }
        }
        //给用户名为admin的用户超级管理员权限
        if ($admininfo['username'] === 'admin') {
            return true;
        }
        //获得登录后的忽略列表
        $ignorance = C('RBAC.IGNORANCE');
        if (in_array($url, $ignorance)) {
            return true;
        }
        //没有权限就回跳并提示
        if (in_array($url,session('ADMIN_PATH'))) {
            return true;
        }else{
            echo "<script type='text/javascript'>alert('没有权限');history.back();</script>";
            exit;
        }

    }
}