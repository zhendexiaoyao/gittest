<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17
 * Time: 17:37
 */

namespace Home\Controller;



use Think\Controller;

class MemberController extends Controller
{
    private $_model = null;
    protected function _initialize(){
        $this->_model = D('Member');
    }
    public function regist(){
        if (IS_POST) {
            if ($this->_model->create('','reg')===false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->addMember() === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('注册成功，请查收邮件及时激活账号！',U('Index/index'));
        }else{
            $this->assign('metaTitle','用户注册');
            $this->display();
        }

    }
    public function login(){
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->checkLogin() === false) {
                $this->error(get_error($this->_model));
            }
            $url = cookie('referer');
            cookie('referer',null);
            if(empty($url)){
                $url = U('Index/index');
            }
            $this->success('登录成功',$url );
        }else{
            $this->assign('metaTitle','用户登录');
            $this->display();
        }

    }
    public function logout(){
        session(null);
        cookie(null);
        $this->success('退出成功',U('login'));
    }
    public function sms($tel){
        if (IS_AJAX) {

            $redis = new \Redis();
            $redis->connect('127.0.0.1');
            if($redis->exists($tel)){
                $times = $redis->get($tel);
                if($times>5){
                    $this->ajaxReturn(false);
                }else{
                    dump($times);
                    $times += 1;
                    $redis->set($tel,$times);
                }
            }else{
                echo '1';
                $redis->set($tel,1);
            }
            vendor('Alidayu.TopSdk');
            date_default_timezone_set('Asia/Shanghai');
            $c = new \TopClient;
            $c ->appkey = '23533639' ;
            $c ->secretKey = '6530872164f7833a2aa0189f6c958e52' ;
            $req = new \AlibabaAliqinFcSmsNumSendRequest;
            $req ->setExtend( "" );
            $req ->setSmsType( "normal" );
            $req ->setSmsFreeSignName( "验证码测试" );
            $data = [
                'name'=>'客户',
                'code'=>\Org\Util\String::randNumber(10000,99999)
            ];
            $code         = [
                'tel'  => $tel,
                'code' => $data['code'],
            ];
            $data = $this->_model->forDelay($tel,$code,$data);

            $req ->setSmsParam( json_encode($data) );
            $req ->setRecNum( $tel );
            $req ->setSmsTemplateCode( "SMS_26075359" );
            $resp = $c ->execute( $req );
            if (isset($resp->result->success)) {
                //发送成功了
                $this->ajaxReturn(true);
            }
        }
        $this->ajaxReturn(false);

    }
    public function active($email,$activeToken) {
        //修改数据库中对应的账户
        if($this->_model->where(['email'=>$email,'active_token'=>$activeToken,'status'=>0])->setField('status',1)){
            $this->success('激活成功',U('Index/index'));
        }else{
            $this->error('激活失败',U('Index/index'));
        }
    }

    /**
     * 前台的ajax验证
     */
    public function checkByParam() {
        $cond = I('get.');
        if($this->_model->where($cond)->count()){
            $this->ajaxReturn(false);
        }else{
            $this->ajaxReturn(true);
        }
    }
    public function layer($tel){
        if ($this->_model->create() === false) {
            $this->error(get_error($this->_model));
        }
            $this->sms(json_decode($tel));
    }
//    public function mail($address) {
//        vendor('PhpMailer.PHPMailerAutoload');
//        $mail = new \PHPMailer;
//        $mail->isSMTP();                                      // Set mailer to use SMTP
//        $mail->Host       = 'smtp.163.com';  // Specify main and backup SMTP servers
//        $mail->SMTPAuth   = true;                               // Enable SMTP authentication
//        $mail->Username   = 'zhendexiaoyao@163.com';                 // SMTP username
//        $mail->Password   = 'xiaoqiyuan1989';                           // SMTP password
//        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
//        $mail->Port       = 465;                                    // TCP port to connect to
//
//        $mail->setFrom('zhendexiaoyao@163.com', '小肖');
//        $mail->addAddress($address);     // Add a recipient
//        $mail->isHTML(true);                                  // Set email format to HTML
//
//        $mail->Subject = '欢迎注册本网站';
//        $mail->Body    = '尊敬的客户，欢迎你注册本网站！';
//        $mail->CharSet = 'UTF-8';
//
//        if (!$mail->send()) {
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;
//        } else {
//            echo 'Message has been sent';
//        }
//    }
}