<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/6
 * Time: 11:50
 */

namespace Admin\Controller;


class ArticleCategoryController extends \Think\Controller
{
    public function index(){
        $article_cate = D('ArticleCategory');
        $data = $article_cate->getPageList();
        $this->assign('pageBar',$data['pageBar']);
        $this->assign('rows',$data['rows']);
        $this->display();
    }
    public function add(){
        if (IS_POST) {
            $article_cate = D('ArticleCategory');
            if ($article_cate->create() === false) {
                $this->error($article_cate->getError());
            }
            if ($article_cate->add() === false) {
                $this->error($article_cate->getError());
            }
                $this->success('添加成功',U('index'));
        }else{
            $this->display();
        }
    }
    public function remove($id=0){
        $article_cate = D('ArticleCategory');
        $rs = $article_cate->where(['id'=>$id])->setField('status',-1);
        if($rs){
            $this->success('删除成功',U('index'));
        }else{
            $this->error('删除失败');
        }
    }
    public function edit($id){
        $article_cate = D('ArticleCategory');
        if (IS_POST) {
            $rows = $article_cate->create();
            if(!$rows){
                $this->error($article_cate->getError());
            }
            if (!$article_cate->save($rows)) {
                $this->error($article_cate->getError());
            }
            $this->success('修改成功',U('index'));
        }else{
            $rs = $article_cate->where(['id'=>$id])->find();
            $this->assign('rs',$rs);
            $this->display('add');
        }
    }

}