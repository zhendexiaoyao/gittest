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

    /**
     * 添加分类的方法
     * @return false|int
     */
    public function addCategory() {
        //使用nestedsets计算节点信息，注意初始化的时候实现接口
        $db_mysql        = new \Admin\Logic\MysqlOrm();
        $NestedSets = new \Admin\Logic\NestedSets($db_mysql, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');

        unset($this->data['id']);
        return $NestedSets->insert($this->data['parent_id'], $this->data, 'bottom');
    }

    /**
     * 修改分类的方法
     * @return bool
     */
    public function saveCategory() {
        //判断两次的parent_id是否一样，如果一样就不必计算节点
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

    /**
     * 删除分类的方法
     * @param $id
     * @return bool
     */
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