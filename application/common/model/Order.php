<?php
namespace app\common\model;

use think\Model;

class Order extends Model
{
    //自动记录时间为真    或者在database.php中设置auto_timestamp 为真
    protected $autoWriteTimestamp = true;

    /**
     * 新增分类
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        $data['status'] = 1;
        //$data['create_time'] = time();
        $this->save($data);
        return $this->id;
    }
    public function updateOrderByOutTradeNo($outTradeNo, $weixinData)
    {
        if(!empty($weixinData['transaction_id'])) {
            $data['transaction_id'] = $weixinData['transaction_id'];
        }
        if(!empty($weixinData['total_fee'])) {
            $data['pay_amount'] = $weixinData['total_fee'] / 100;
            $data['pay_status'] = 1;
        }
        if(!empty($weixinData['time_end'])) {
            $data['pay_time'] = $weixinData['time_end'];
        }
        return $this->allowField(true)->save($data, ['out_trade_no' => $outTradeNo]);
    }
    public function getOrderByUsername($username)
    {
        $data = [
            'username' => $username,
            'status' => 1,
        ];
        $order = [
            'id' => 'desc',
        ];
        $res = $this->where($data)
            ->order($order)
            ->paginate();
        return $res;
    }
}