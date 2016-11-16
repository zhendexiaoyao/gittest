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
        $ignores = C('RBAC.IGNORES');
        $url     = MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;
        if (in_array($url, $ignores)) {
            return true;
        }
        $admininfo = session('ADMIN_INFO');
        if (!$admininfo) {
            if (!D('Admin')->autoLogin()) {
                $url = U('Admin/login');
                redirect($url);
            }
        }
        if ($admininfo['username'] === 'admin') {
            return true;
        }
        $ignorance = C('RBAC.IGNORANCE');
        if (in_array($url, $ignorance)) {
            return true;
        }
        if (in_array($url,session('ADMIN_PATH'))) {
            return true;
        }else{
            echo "<script type='text/javascript'>alert('没有权限');history.back();</script>";
            exit;
        }

    }
}