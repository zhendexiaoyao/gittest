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
    /**
     * 商品分类列表
     */
    public function index(){
        //获得全部商品分类信息
        $rows = $this->_model->getCategories();
        $this->assign('rows', $rows);
        $this->display();

    }
    /**
     * 添加商品分类
     */
    public function add(){
        if (IS_POST) {
            //收集商品分类数据
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            //添加商品分类
            if ($this->_model->addCategory() === false) {
                $this->error($this->_model->getError());
            }
            $this->success('添加成功', U('index'));
        }else{
            //显示所有商品分类
            $this->_categories();
            $this->display();
        }
    }
    /**
     * 删除商品分类
     */
    public function remove($id){
        //删除分类
        if ($this->_model->deleteCategory($id) === false) {
            $this->error($this->_model->getError());
        }
        $this->success('删除成功', U('index'));
    }
    /**
     * 编辑商品分类
     */
    public function edit($id){
        if (IS_POST) {
            //收集提交的数据
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            //修改商品分类
            if ($this->_model->saveCategory() === false) {
                $this->error($this->_model->getError());
            }
            $this->success('修改成功', U('index'));
        } else {
            //获得需要修改商品分类的信息
            $rs = $this->_model->find($id);
            $this->assign('rs', $rs);
            //获得所有已有的分类
            $this->_categories();
            $this->display('add');
        }
    }
    /**
     * 提供所有分类的json信息
     */
    private function _categories() {
        $rows = $this->_model->getCategories();
        array_unshift($rows, ['id' => 0, 'name' => '顶级分类']);
        $categories = json_encode($rows);
        $this->assign('categories', $categories);
    }
}