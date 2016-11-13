<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/6
 * Time: 16:25
 */

namespace Admin\Model;


class ArticleModel extends \Think\Model
{
    public $_validate = [
        ['name','require','文章名称不能为空']
    ];
    public function addArticle($content){
        $this->startTrans();
        $article_detail = M('article_detail');
        $this->data['inputtime'] = NOW_TIME;
        $article_id = $this->add();
        if ($article_id === false) {
            $this->rollback();
            return false;
        }
        $data = ['article_id'=>$article_id,'content'=>$content];
        if ($article_detail->add($data) === false) {
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
    public function getPageList(array $cond = []){
        $cond = array_merge(['shop_article.status'=>['neq',-1]],$cond);
        $total = $this->where($cond)->count();
        if(!$total){
            echo $this->getError();
        }
        $page = new \Think\Page($total,C('PAGE_MODE.SIZE'));
        $page->setConfig('theme', C('PAGE_MODE.THEME'));
        $pageBar = $page->show();
        $rows = $this->field('shop_article_category.name as cate_name,shop_article.*')->join('shop_article_category ON shop_article_category.id = shop_article.article_category_id')->where($cond)->order('shop_article.sort')->page($_GET['p'],C('PAGE_MODE.SIZE'))->select();
        $data = ['pageBar'=>$pageBar,'rows'=>$rows];
        return $data;
    }
    public function update($content){
        $this->startTrans();
        $article_detail = M('article_detail');
        $article_id = $this->data['id'];
        $this->data['inputtime'] = NOW_TIME;
        if ($this->save() === false) {
            $this->rollback();
            return false;
        }
        $rs = $article_detail->where(['article_id'=>$article_id])->setField('content',$content);
        if ($rs === false) {
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
}