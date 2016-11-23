<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/23
 * Time: 11:25
 */

namespace Admin\Model;


use Think\Model;

class BannerModel extends Model
{   protected $_validate = [
    ['url','require','跳转路径不能为空'],
    ['path','require','请上传图片'],
    ['notice','require','文字提示不能为空'],
    ['start_time','require','开始时间不能为空'],
    ['end_time','require','结束时间不能为空'],
];
    //开启批量验证
    protected $patchValidate    =   true;
    public function addBanner(){
        $this->data['start_time'] = strtotime($this->data['start_time']);
        $this->data['end_time'] = strtotime($this->data['end_time']);
        return $this->add();
    }
    public function getPageList(array $cond = []){
        $total = $this->where($cond)->count();
        if(!$total){
            echo $this->getError();
        }
        $page = new \Think\Page($total,C('PAGE_MODE.SIZE'));
        $page->setConfig('theme', C('PAGE_MODE.THEME'));
        $pageBar = $page->show();
        $rows = $this->where($cond)->order('sort')->page($_GET['p'],C('PAGE_MODE.SIZE'))->select();
        $data = ['pageBar'=>$pageBar,'rows'=>$rows];
        return $data;
    }
    public function getInfo($id){
        $row = $this->find($id);
        return $row;
    }
    public function updateBanner(){
        $this->data['start_time'] = strtotime($this->data['start_time']);
        $this->data['end_time'] = strtotime($this->data['end_time']);
        return $this->save();
    }
}