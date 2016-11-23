<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 21:35
 */

namespace Home\Model;


use Think\Model;

class LocationsModel extends Model
{
    public function getListByParentId($parentId=0){
        return $this->where(['parent_id'=>$parentId])->select();
    }
}