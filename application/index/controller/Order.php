<?php
namespace app\index\controller;
use think\Controller;
class Order extends Base
{
    public function index()
    {
        $user = $this->getLoginUser();
        if(!$user) {
            $this->error('请登录', url('user/login'));
        }
        $id = input('get.id', 0, 'intval');
        if(!$id) {
            $this->error('参数不合法');
        }
        $dealCount = input('get.deal_count', 1, 'intval');
        $totalPrice = input('get.total_price', 0);
        $deal = model('Deal')->find($id);
        if(!$deal || $deal->status != 1) {
            $this->error('商品不存在');
        }
        if(empty($_SERVER['HTTP_REFERER'])) {
            $this->error('请求不合法');
        }

        $orderSn = setOrderSn();
        //组装数据
        $data = [
            'out_trade_no' => $orderSn,
            'user_id' => $user->id,
            'username' => $user->username,
            'deal_id' => $id,
            'deal_count' => $dealCount,
            'total_price' => $totalPrice,
            'referer' => $_SERVER['HTTP_REFERER'],
        ];
        try {
            $orderId = model('Order')->add($data);
        }catch (\Exception $e) {
            $this->error('订单处理失败');
        }
        $this->redirect('pay/index', ['id' => $orderId]);
    }

    public function confirm()
    {
        if(!$this->getLoginUser()) {
            $this->error('请登录', url('user/login'));
        }
        $id = input('get.id', 0, 'intval');
        if(!$id) {
            $this->error('参数不合法');
        }
        $count = input('get.count', 1, 'intval');
        $deal = model('Deal')->find($id);
        //echo model('Deal')->getLastSql();exit;
        if(!$deal || $deal->status != 1) {
            $this->error('商品不存在');
        }
        $deal = $deal->toArray();//对象转换为数组

        return $this->fetch('', [
            'controller' => 'pay',
            'count' => $count,
            'deal' => $deal,
        ]);
    }
}
