<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/13
 * Time: 11:50
 */

namespace Admin\Controller;


use Think\Controller;

class RoleController extends Controller
{
    private $_model;
    protected function _initialize(){
        $this->_model = D('Permission');
    }
    public function index(){

    }
    public function add(){

    }
    public function edit(){

    }
    public function remove(){

    }
}