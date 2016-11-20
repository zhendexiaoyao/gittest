<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/12
 * Time: 20:42
 */
function get_error($model){
    $all_error = '<ul>';
    $error = $model->getError();
    if(!is_array($error)){
        return $error;
    }
    foreach($error as $val){
        $all_error .= '<li>'.$val.'</li>';
    }
    return $all_error .='</ul>';
}
function show_words($word){
    if (strlen($word)>30) {
        return mb_substr($word,0,30,'utf-8').'...';
    }else{
        return $word;
    }
}
function sendMail($address,$subject,$content){
        vendor('PhpMailer.PHPMailerAutoload');
        $mail = new \PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host       = 'smtp.163.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                               // Enable SMTP authentication
        $mail->Username   = 'zhendexiaoyao@163.com';                 // SMTP username
        $mail->Password   = 'xiaoqiyuan1989';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465;                                    // TCP port to connect to

        $mail->setFrom('zhendexiaoyao@163.com', '天狗商城');
        $mail->addAddress($address);     // Add a recipient
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $content;
        $mail->CharSet = 'UTF-8';

    if(!$mail->send()){
        $data = [
            'status'=>false,
            'msg'=>$mail->ErrorInfo,
        ];
    }else{
        $data = [
            'status'=>true,
            'msg'=>'发送成功',
        ];
    }
    return $data;
}