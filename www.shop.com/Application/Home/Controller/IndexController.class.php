<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
//    private $_model = null;
//    protected function _initialize(){
//        $this->_model = D('Index');
//    }
    public function index(){
        $rows = M('GoodsCategory')->order('lft')->select();
        $this->assign('rows',$rows);
        $this->display();
    }

}