<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/8
 * Time: 21:53
 */

namespace Admin\Logic;


class MysqlOrm implements DbMysql
{
    private function _getSql(array $args){
        $sql  = array_shift($args); //获得数组的sql结构
        $sqls = preg_split('/\?[FTN]/', $sql); //将sql结构转换成数组
        array_pop($sqls); //弹出最后的空元素
        $sql  = '';//循环组成最后的sql语句
        foreach ($sqls as $key => $value) {
            $sql .=$value . $args[$key];
        }
        return $sql;
    }
    public function connect()
    {
        // TODO: Implement connect() method.
        echo '<pre>';
        echo __METHOD__ . '<br />';
        var_dump(func_get_args());
        echo '<hr />';
    }

    public function disconnect()
    {
        // TODO: Implement disconnect() method.
        echo '<pre>';
        echo __METHOD__ . '<br />';
        var_dump(func_get_args());
        echo '<hr />';
    }

    public function free($result)
    {
        // TODO: Implement free() method.
        echo '<pre>';
        echo __METHOD__ . '<br />';
        var_dump(func_get_args());
        echo '<hr />';
    }

    public function query($sql, array $args = array())
    {
        $args = func_get_args();
        $sql = $this->_getSql($args);
        return M()->execute($sql);
        // TODO: Implement query() method.
//        echo '<pre>';
//        echo __METHOD__ . '<br />';
//        var_dump(func_get_args());
//        echo '<hr />';
    }

    public function insert($sql, array $args = array())
    {
        $table = func_get_arg(1);
        $data = func_get_arg(2);
        return M()->table($table)->add($data);
        // TODO: Implement insert() method.
//        echo '<pre>';
//        echo __METHOD__ . '<br />';
//        var_dump(func_get_args());
//        echo '<hr />';
    }

    public function update($sql, array $args = array())
    {
        // TODO: Implement update() method.
        echo '<pre>';
        echo __METHOD__ . '<br />';
        var_dump(func_get_args());
        echo '<hr />';
    }

    public function getAll($sql, array $args = array())
    {
        // TODO: Implement getAll() method.
        echo '<pre>';
        echo __METHOD__ . '<br />';
        var_dump(func_get_args());
        echo '<hr />';
    }

    public function getAssoc($sql, array $args = array())
    {
        // TODO: Implement getAssoc() method.
        echo '<pre>';
        echo __METHOD__ . '<br />';
        var_dump(func_get_args());
        echo '<hr />';
    }

    public function getRow($sql, array $args = array())
    {
        $args = func_get_args();
        $sql = $this->_getSql($args);
        return array_pop(M()->query($sql));
        // TODO: Implement getRow() method.
//        echo '<pre>';
//        echo __METHOD__ . '<br />';
//        var_dump(func_get_args());
//        echo '<hr />';
    }

    public function getCol($sql, array $args = array())
    {
        // TODO: Implement getCol() method.
        echo '<pre>';
        echo __METHOD__ . '<br />';
        var_dump(func_get_args());
        echo '<hr />';
    }

    public function getOne($sql, array $args = array())
    {
        $args = func_get_args();
        $sql = $this->_getSql($args);
        $rows = M()->query($sql);
        $row = array_pop($rows);
        $field = array_pop($row);
        return $field;
        // TODO: Implement getOne() method.
//        echo '<pre>';
//        echo __METHOD__ . '<br />';
//        var_dump(func_get_args());
//        echo '<hr />';
    }

}