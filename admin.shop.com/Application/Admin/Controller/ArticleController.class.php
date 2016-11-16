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
    /**
     * 文章列表
     */
    public function index(){
        $cond    = [];
        $keyword ='';
        if(IS_GET){
            $keyword = trim(I('get.keyword'));
        }
        if($keyword){
            $cond['username'] = ['like','%'.$keyword.'%'];
        }

        $article = D('Article');
        //获取文章分页数据
        $data = $article->getPageList($cond);
        $this->assign('pageBar',$data['pageBar']);
        $this->assign('rows',$data['rows']);
        $this->display();
    }
    /**
     * 文章添加
     */
    public function add(){
        if (IS_POST) {
            $article = D('Article');
            //获取文章内容
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
            //获取文章分类
            $cate = $article_cate->getCate();
            $this->assign('cate',$cate);
            $this->display();
        }

    }
    /**
     * 文章详情
     */
    public function showDetail($id){
        $article_detail = M('article_detail');
        $article = D('Article');
        $article_id = $id;
        //获取文章信息
        $rs = $article->where(['id'=>$id])->find();
        //获取文章内容
        $row = $article_detail->where(['article_id'=>$article_id])->find();
        $this->assign('row',$row);
        $this->assign('rs',$rs);
        $this->display();
    }
    /**
     * 文章删除
     */
    public function remove($id){
        $article = D('Article');
        $rs = $article->where(['id'=>$id])->setField('status',-1);
        if($rs){
            $this->success('删除成功',U('index'));
        }else{
            $this->error('删除失败');
        }
    }
    /**
     * 文章编辑
     */
    public function edit($id){
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
            //联表显示文章基本信息和详细内容
            $row = $article->field('shop_article.*,shop_article_detail.content')->join('shop_article_detail ON shop_article.id = shop_article_detail.article_id')->where(['shop_article.id'=>$id])->find();
            $this->assign('row',$row);
            $this->display('add');
        }
    }
}