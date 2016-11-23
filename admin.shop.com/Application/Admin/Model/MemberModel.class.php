<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/23
 * Time: 18:12
 */

namespace Admin\Model;


use Org\Util\String;
use Think\Model;

class MemberModel extends Model
{
    public function updateMember(){
        $salt = String::randString();
        $this->data['salt'] = $salt;
        $this->data['password'] = md5(md5($this->data['password']).md5($salt));
        if ($this->save() ===false) {
            $this->error = '数据有误';
        }
    }
    public function get_member($id){
        $row = $this->find($id);
        return $row;
    }
}