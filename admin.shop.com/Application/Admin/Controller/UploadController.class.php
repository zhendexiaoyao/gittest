<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/5
 * Time: 23:03
 */

namespace Admin\Controller;


class UploadController extends \Think\Controller
{
    public function upload(){
        $config   = [
            'mimes'        => array('image/jpeg', 'image/png', 'image/gif'), //允许上传的文件MiMe类型
            'maxSize'      => 0, //上传的文件大小限制 (0-不做限制)
            'exts'         => array('jpg', 'jpeg', 'jpe','png','gif'), //允许上传的文件后缀
            'autoSub'      => false, //自动子目录保存文件
          //  'subName'      => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath'     => './', //保存根路径
            'savePath'     => 'Uploads/', //保存路径
            'saveName'     => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
            'saveExt'      => '', //文件保存后缀，空则使用原后缀
            'replace'      => false, //存在同名是否覆盖
            'hash'         => false, //是否生成hash编码
            'callback'     => false, //检测文件是否存在回调，如果存在返回文件信息数组
            'driver'       => 'Qiniu', // 文件上传驱动
            'driverConfig' => array(
                'secretKey' => 'TOtC_HL-nYTPDOipyc7ITV3oJNpeCArjRJ1YOdnG', //七牛服务器
                'accessKey' => 'C2yWnx3pb3lHaa2DpDG3wvwgoLoT1068rkrALQhg', //七牛用户
                'domain'    => 'og9n3lf9v.bkt.clouddn.com/', //域名
                'bucket'    => 'tpmall', //空间名称
                'timeout'   => 30, //超时时间
            ), // 上传驱动配置
        ];
        $upload = new \Think\Upload($config);
        $file = $upload->upload();
        $file = array_pop($file);
        $data = [];
        if(!$file){
            $data = [
                'status'=>false,
                'msg'=>$upload->getError(),
                'url'=>''
            ];
        }else{
            if($upload->driver == 'Qiniu'){
                $url = $file['url'];
            }else{
                $url = C('BASE_URL').$upload->rootPath.$file['savepath'].$file['savename'];
            }
            $data = [
                'status'=>true,
                'msg'=>'上传成功',
                'url'=>$url
            ];
        }
        return $this->ajaxReturn($data);//为ajax返回数据时，只能echo或者ajaxReturn
    }
}