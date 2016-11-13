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
        $ignores = [
            'Admin/Admin/login',
            'Admin/Admin/verify',
        ];
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
        return true;
    }
}