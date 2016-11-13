<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/6
 * Time: 14:40
 */

namespace Admin\Model;


class ArticleCategoryModel extends \Think\Model
{
    public $_validate =[
        ['name','require','分类名不能为空']
    ];
    public function getPageList(){
        $cond = ['status'=>['neq',-1]];
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
    public function getCate(){
        $rows = $this->field('id,name')->select();

        return $rows;
    }
}