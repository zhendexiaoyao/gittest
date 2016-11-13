<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/6
 * Time: 16:01
 */

namespace Admin\Controller;


class ArticleController extends \Think\Controller
{
    public function index(){
        $cond    = [];
        $keyword ='';
        if(IS_GET){
            $keyword = trim(I('get.keyword'));
        }
        if($keyword){
            $cond['username'] = ['like','%'.$keyword.'%'];
        }

        $article = D('Admin');
        $data = $article->getPageList($cond);
        $this->assign('pageBar',$data['pageBar']);
        $this->assign('rows',$data['rows']);
        $this->display();
    }
    public function add(){
        if (IS_POST) {
            $article = D('Article');
            $content = I('post.content','',false);
            if ($article->create() === false) {
                $this->error($article->getError());
            }
            if ($article->addArticle($content) === false) {
                $this->error($article->getError());
            }
            $this->success('添加成功',U('index'));
        }else{
            $article_cate = D('ArticleCategory');
            $cate = $article_cate->getCate();
            $this->assign('cate',$cate);
            $this->display();
        }

    }
    public function showDetail($id){
        $article_detail = M('article_detail');
        $article = D('Article');
        $article_id = $id;
        $rs = $article->where(['id'=>$id])->find();
        $row = $article_detail->where(['article_id'=>$article_id])->find();
        $this->assign('row',$row);
        $this->assign('rs',$rs);
        $this->display();
    }
    public function remove($id){
        $article = D('Article');
        $rs = $article->where(['id'=>$id])->setField('status',-1);
        if($rs){
            $this->success('删除成功',U('index'));
        }else{
            $this->error('删除失败');
        }
    }
    public function edit($id=0){
        $article = D('Article');
        $content = I('post.content');
        if (IS_POST) {
            $rows = $article->create();
            if(!$rows){
                $this->error($article->getError());
            }
            if (!$article->update($content)) {
                $this->error($article->getError());
            }
            $this->success('修改成功',U('index'));
        }else{
            $article_cate = D('ArticleCategory');
            $cate = $article_cate->getCate();
            $this->assign('cate',$cate);
            $row = $article->field('shop_article.*,shop_article_detail.content')->join('shop_article_detail ON shop_article.id = shop_article_detail.article_id')->where(['shop_article.id'=>$id])->find();
            $this->assign('row',$row);
            $this->display('add');
        }
    }
}