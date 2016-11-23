<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 22:40
 */

namespace Home\Controller;


use Think\Controller;

class AddressController extends Controller
{   private $_model = null;
    protected function _initialize(){
        $this->_model = D('Address');
    }
    public function addAddress(){
        if (IS_POST) {
            if ($this->_model->create()===false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->addAddress()===false) {
                $this->error(get_error($this->_model));
            }
            $this->success('添加成功',U('Index/address'));
        }else{
            $this->error('错误',U('Index/address'));
        }
    }
}