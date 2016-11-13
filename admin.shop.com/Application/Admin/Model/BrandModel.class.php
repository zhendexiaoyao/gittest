<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/5
 * Time: 13:48
 */

namespace Admin\Model;


class BrandModel extends \Think\Model
{
    protected $_validate = [
        ['name','require','商品名不能为空'],
    ];
    public function getPageList(array $cond = []){
        $cond = array_merge(['status'=>['neq',-1]],$cond);
        $total = $this->where($cond)->count();
        $page = new \Think\Page($total,C('PAGE_MODE.SIZE'));
        $page->setConfig('theme', C('PAGE_MODE.THEME'));
        $pageBar = $page->show();
        $rows = $this->where($cond)->order('sort')->page($_GET['p'],C('PAGE_MODE.SIZE'))->select();
        return $data = [
            'pageBar'=>$pageBar,
            'rows'=>$rows
        ];
    }
}