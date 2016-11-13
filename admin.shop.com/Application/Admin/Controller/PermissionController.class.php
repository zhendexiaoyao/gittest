<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/13
 * Time: 11:53
 */

namespace Admin\Controller;


use Think\Controller;

class PermissionController extends Controller
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