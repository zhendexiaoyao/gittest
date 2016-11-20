<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 18:39
 */

namespace Home\Controller;


use Think\Controller;
use Think\Verify;

class CaptchaController extends Controller
{
    public function show(){
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
}