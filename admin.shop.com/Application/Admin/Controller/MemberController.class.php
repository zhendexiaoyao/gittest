<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/23
 * Time: 16:24
 */

namespace Admin\Controller;


use Think\Controller;

class MemberController extends Controller
{
    private $_model;
    protected function _initialize(){
        $this->_model = D('Member');
    }
    public function index(){
        $rows = $this->_model->select();
        $this->assign('rows',$rows);
        $this->display();
    }
    public function edit($id){
        if (IS_POST) {
            if ($this->_model->create()===false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->updateMember()===false) {
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功',U('index'));
        }else{
            $row=$this->_model->get_member($id);
            $this->assign('row',$row);
            $this->display();
        }
    }
}