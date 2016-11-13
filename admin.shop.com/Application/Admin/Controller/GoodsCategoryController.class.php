<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/8
 * Time: 16:43
 */

namespace Admin\Controller;


class GoodsCategoryController extends \Think\Controller
{
    /**
     *因为会频繁使用GoodsCategoryModel的对象，可以讲实例化的Model对象存在方法的私有
     *属性中方便调用
     */
    private $_model;
    /**
     *在控制器内有构造方法调用_initialize()方法
     * */
    public function _initialize() {
        $this->_model = D('GoodsCategory');
    }
    public function index(){
        $rows = $this->_model->getCategories();
        $this->assign('rows', $rows);
        $this->display();

    }
    public function add(){
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->addCategory() === false) {
                $this->error($this->_model->getError());
            }
            $this->success('添加成功', U('index'));
        }else{
            $this->_categories();
            $this->display();
        }
    }
    public function remove($id){
        if ($this->_model->deleteCategory($id) === false) {
            $this->error($this->_model->getError());
        }
        $this->success('删除成功', U('index'));
    }
    public function edit($id){
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->saveCategory() === false) {
                $this->error($this->_model->getError());
            }
            $this->success('修改成功', U('index'));
        } else {
            $rs = $this->_model->find($id);
            $this->assign('rs', $rs);

            $this->_categories();
            $this->display('add');
        }
    }
    private function _categories() {
        $rows = $this->_model->getCategories();
        array_unshift($rows, ['id' => 0, 'name' => '顶级分类']);
        $categories = json_encode($rows);
        $this->assign('categories', $categories);
    }
}