<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    protected function _initialize(){
        $rows = M('GoodsCategory')->order('lft')->select();
        $this->assign('rows',$rows);
        $result = D('ArticleCategory')->getHelpArticles();
        $this->assign($result);
    }
    public function index(){

        $goods = D('Goods');
        $goodsData = [
            'is_good'=>$goods->getGoodsByStatus(1),
            'is_new'=>$goods->getGoodsByStatus(2),
            'is_hot'=>$goods->getGoodsByStatus(4),
        ];
        $banner = M('Banner');
        $time = time();
        $rows = $banner->where(['status'=>1,'start_time'=>['lt',$time],'end_time'=>['gt',$time]])->order('sort')->select();
        $this->assign('rs',$rows);
        $this->assign($goodsData);

        $this->display();
    }
    public function goods($id) {
        $row = D('Goods')->getGoodsInfo($id);
        if (empty($row)) {
            $this->redirect('Index/index');
        }
        $this->assign('row', $row);
        $this->assign('meta_title', $row['name'] . '  -商品详情');
        $this->display();
    }
    public function address(){
        //获取省级名称
        $provinces = D('Locations')->getListByParentId();
        $addresses = D('Address')->getList();
        $this->assign('addresses',$addresses);
        $this->assign('provinces',$provinces);
        $this->display();

    }
    public function addressEdit($id) {
        //获取收货地址详情
        $row = D('Address')->find($id);
        $this->assign('row',$row);
        //获取省级菜单
        $provinces = D('Locations')->getListByParentId();
        $this->assign('provinces',$provinces);
        $this->display();
    }
    public function removeAddress($id){
        $address = D('Address');
        if ($address->delete($id)===false) {
            $this->error(get_error($address));
        }
        $this->success('删除成功',U('address'));
    }
    public function is_defaultAddress($id){
        $member_id = session('USER_INFO')['id'];
        $address = D('Address');
        if ($address->where(['member_id'=>$member_id])->setField('is_default',0)===false) {
            $this->error(get_error($address));
        }
        if ($address->where(['id'=>$id])->setField('is_default',1)===false) {
            $this->error(get_error($address));
        }
        $this->success('设置成功',U('address'));
    }

}