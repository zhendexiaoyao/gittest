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
        $userinfo = session('USER_INFO');
        //没有session则验证自动登录
        if (!$userinfo) {
            if (!D('Member')->autoLogin()) {
                $url = U('Member/login');
                redirect($url);
            }
        }
    }
}