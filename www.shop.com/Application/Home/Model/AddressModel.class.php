<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 22:23
 */

namespace Home\Model;


use Think\Model;

class AddressModel extends Model
{
    public function addAddress(){
        $member_id = session('USER_INFO')['id'];
        if (!empty($this->data['is_default'])) {
            $this->where(['member_id'=>$member_id])->setField('is_default',0);
        }
        $this->data['member_id'] = $member_id;
        return $this->add();
    }
    public function getList(){
        $member_id = session('USER_INFO')['id'];
        return $this->where(['member_id'=>$member_id])->select();
    }
}