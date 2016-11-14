<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/12
 * Time: 20:42
 */
function get_error($model){
    $all_error = '<ul>';
    $error = $model->getError();
    if(!is_array($error)){
        return $error;
    }
    foreach($error as $val){
        $all_error .= '<li>'.$val.'</li>';
    }
    return $all_error .='</ul>';
}
function show_words($word){
    if (strlen($word)>30) {
        return mb_substr($word,0,30,'utf-8').'...';
    }else{
        return $word;
    }
}