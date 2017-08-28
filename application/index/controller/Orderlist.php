<?php
namespace app\index\controller;
use think\Controller;
class Orderlist extends Base
{
    public function index()
    {
        $user = $this->getLoginUser()->username;
        $order = model('Order')->getOrderByUsername($user);
        return $this->fetch('',[
            'controller' => 'lists',
            'title' => '我的订单',
            'order' => $order,
        ]);
    }
}
