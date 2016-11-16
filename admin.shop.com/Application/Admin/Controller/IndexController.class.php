<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
    }
    public function top(){
        $this->display();
    }
    public function menu(){
        $menus = D('Menu')->getVisableMenu();//获得管理员名下可以看到的菜单
        $this->assign('menus',$menus);
        $this->display();
    }
    public function main(){
        $this->display();
    }

}