<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 21:52
 */

namespace Home\Controller;


use Think\Controller;

class LocationsController extends Controller
{
    private $_model = null;
    protected function _initialize(){
    $this->_model = D('Locations');
}
    public function getListByParentId($parent_id){
        if(IS_AJAX){
            $list = $this->_model->getListByParentId($parent_id);
            $this->ajaxReturn($list);
        }
    }
}