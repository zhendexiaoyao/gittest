<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 17:38
 */

namespace Home\Model;


use Think\Model;
use Think\Verify;

class MemberModel extends Model
{
    protected $patchValidate = true;
    protected $_validate = [
        ['username','require','用户名必须填写！'],
        ['username','','用户名已存在','','unique','reg'],
        ['username','3,20','用户名必须是3-20位','','length'],
        ['password', 'require', '密码不能为空'],
        ['password','6,20','密码必须是6-20位','','length'],
        ['repassword', 'password', '两次密码不一致','', 'confirm'],
        ['email', 'require', '邮箱不能为空'],
        ['email', 'email', '邮箱不合法'],
        ['email', '', '邮箱已存在', '', 'unique'],
        ['tel', 'require', '手机号码不能为空'],
        ['tel', '/^1[34578]\d{9}$/', '手机号码不合法','', 'regex'],
        ['tel', '', '手机号码已存在','', 'unique'],
        ['checkcode','require','验证码不能为空'],
        ['checkcode','checkCaptcha','验证码不正确','','callback'],
        ['captcha', 'checkTelcode', '手机验证码不合法', self::MUST_VALIDATE, 'callback', 'reg'],
    ];
    protected $_auto = [
        ['add_time',NOW_TIME,'reg'],
        ['salt','\Org\Util\String::randString','reg','function'],
    ];
    protected function checkCaptcha($code){
        $captcha = new Verify();
        return $captcha->check($code);
    }
    protected function checkTelcode($telCode){
        $sess_code = session('TEL_CODE');
        if (empty($sess_code)) {
            return false;
        }
        session('TEL_CODE', null);
        return $telCode == $sess_code['code']&& I('post.tel') == $sess_code['tel'] ;
    }
    public function addMember(){
        $this->data['password'] = md5(md5($this->data['password']).md5($this->data['salt']));
        $address = $this->data['email'];
        $subject = '欢迎注册本网站';
        $activeToken = \Org\Util\String::randString(32);
        $url     = U('Member/active', ['activeToken' => $activeToken, 'email' => $address], '', true);
        $content = '<h2>欢迎注册</h2><p>感谢您注册天狗购物网站,账号需要激活才能使用,请点击<a href="' . $url . '">激活链接</a></p><p>如果无法点击,请复制下面的地址在浏览器中粘贴打开' . $url . '</p>';
        if(!$rst = sendMail($address, $subject, $content)){
            dump($rst);
            exit;
        }
        $this->data['active_token'] = $activeToken;
        return $this->add();
    }
    public function checkLogin(){
        $username   = $this->data['username'];
        $password   = $this->data['password'];
        $user_info = $this->getByUsername($username); //调用find获取数据，所以之后的data属性都是数据库中的数据
        if (empty($user_info)) {
            $this->error = '用户名或密码不匹配';
            return false;
        }
        $salt     = $user_info['salt'];
        $password = md5(md5($password).md5($salt));

        if ($password == $user_info['password']) {
            $data = [
                'last_login_time' => NOW_TIME,
                'last_login_ip'   => get_client_ip(1),
                'id'              => $user_info['id'],
            ];
            $this->save($data);
            session('USER_INFO', $user_info);
            $this->_saveToken($user_info, I('post.remember'));
            return true;
        } else {
            $this->error = '用户名或密码不匹配';
            return false;
        }
    }
    private function _saveToken($user_info, $is_remember = false) {
        if ($is_remember) {
            $token = \Org\Util\String::randString(32);
            $data  = [
                'id'    => $user_info['id'],
                'token' => $token,
            ];
            cookie('TOKEN', $data, 604800);
            $this->save($data);
        }
    }
    public function forDelay($tel,$code,$data){
        $sms = M('Sms');
        $tel_info = $sms->getByTel($tel);
        if(empty($tel_info)){
            $rs = ['tel'=>$tel,'send_time'=>time(),'code'=>$data['code']];
            $sms->add($rs);
            session('TEL_CODE', $code);
            return ;
        }
        $interval = ceil((time() - $tel_info['send_time'])/60);
        if ($interval<2) {
            $data['code'] = $code['code'] = $tel_info['code'];
        }else{

            $result = ['tel'=>$tel,'send_time'=>time(),'code'=>$data['code']];
            $sms->save($result);
        }
        session('TEL_CODE', $code);
        return $data;
    }
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
}