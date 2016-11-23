<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 13:59
 */

namespace Home\Model;


use Think\Model;

class ArticleCategoryModel extends Model
{
    public function getHelpArticles(){
        //文章分类id和名称
        $article_categories = $this->where(['is_help'=>1,'status'=>1])->order('sort')->getField('id,name');
        $article_model = M('Article');
        $articles = [];
        foreach($article_categories as $cat_id=>$cat_name){
            $articles[$cat_id] = $article_model->where(['article_category_id'=>$cat_id,'status'=>1])->order('sort')->limit(6)->getField('id,name');
        }
        return compact('article_categories','articles');
    }
}