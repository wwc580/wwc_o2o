<?php
namespace app\api\controller;

use think\Controller;

class Order extends Controller
{
    public function payStatus()
    {
        $id = input('post.id', 0 ,'intval');
        if(!$id) {
            return show(0, 'error');
        }

        $order = model('Order')->get($id);
        if($order->pay_status == 1) {
            return show(1, 'success');
        }
        return show(0, 'error');
    }
    public function updatestatus()
    {
        $id = input('post.id', 0, 'intval');
        $order = model('Order')->get($id);
        if(!$order || $order->pay_status == 1) {
            return show(0, 'error');
        }
        try {
            model('Order')->save(['pay_status' => 1], ['id' => $id]);
            model('Deal')->updateBuyCountById($order->deal_id, $order->deal_count);
        }catch (\Exception $e) {
            return show(0, $e->getMessage());
        }
        return show(1, 'success');
    }
}