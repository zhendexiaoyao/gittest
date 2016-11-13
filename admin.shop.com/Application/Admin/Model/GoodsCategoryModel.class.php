<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/8
 * Time: 16:46
 */

namespace Admin\Model;


class GoodsCategoryModel extends \Think\Model
{
    /**
     *按照左节点将分类排序获得的全部分类
     */
    public function getCategories() {
        return $this->order('lft')->select();
    }
    public function addCategory() {
        $db_mysql        = new \Admin\Logic\MysqlOrm();
        $NestedSets = new \Admin\Logic\NestedSets($db_mysql, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');

        unset($this->data['id']);
        return $NestedSets->insert($this->data['parent_id'], $this->data, 'bottom');
    }
    public function saveCategory() {
        $old_parent_id = $this->where(['id' => $this->data['id']])->getField('parent_id');
        if ($old_parent_id != $this->data['parent_id']) {
            $db_mysql        = new \Admin\Logic\MysqlOrm();
            $NestedSets = new \Admin\Logic\NestedSets($db_mysql, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
            if ($NestedSets->moveUnder($this->data['id'], $this->data['parent_id'], 'bottom') === false) {
                $this->error = '不能将分类移动到后代分类中';
                return false;
            }
        }
        return $this->save();
    }

    public function deleteCategory($id) {
        $db_mysql        = new \Admin\Logic\MysqlOrm();
        $NestedSets = new \Admin\Logic\NestedSets($db_mysql, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
        if ($NestedSets->delete($id) === false) {
            $this->error = '删除失败';
            return false;
        }
        return true;
    }
}