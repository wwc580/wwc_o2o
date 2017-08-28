<?php
namespace app\common\model;

use think\Model;

class Deal extends BaseModel
{
    public function getDealByStatus($status=0)
    {
        $order = [
            'id' => 'desc',
        ];
        $data = [
            'status' => $status,
        ];
        $result = $this->where($data)
            ->order($order)
            ->paginate(1);
        return $result;
    }
    public function getNormalDeals($data = [])
    {
        $data['status'] = 0;
        $order = [
            'id' => 'desc',
        ];
        $result = $this->where($data)
            ->order($order)
            ->paginate(1);
        //echo $this->getLastSql();
        return $result;
    }

    /**
     * 根据分类和城市获取商品数据
     * @param $id 分类
     * @param $cityId 城市
     * @param int $limit 条数
     */
    public function getNormalDealByCategoryCityId($id, $cityId, $limit=10)
    {
        $data = [
            'end_time' => ['gt', time()],
            'category_id' => $id,
            'se_city_id' => $cityId,
            'status' => 1,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        $result = $this->where($data)->order($order);
        if($limit) {
            $result = $result->limit($limit);
        }
        return $result->select();
        //echo $this->getLastSql();
    }
    public function getDealByConditions($data=[], $orders) {
        if(!empty($orders['order_sales'])) {
            $order['buy_count'] = 'desc';
        }
        if(!empty($orders['order_price'])) {
            $order['current_price'] = 'desc';
        }
        if(!empty($orders['order_time'])) {
            $order['create_time'] = 'desc';
        }
        $order['id'] = 'desc';
        $datas[] = "end_time >".time(); //或者 linux crontab 定时扫描数据表设置status
        //find_in_set(11, 'se_category_id') mysql中的函数 11,27,36
        if(!empty($data['se_category_id'])) {
            $datas[] = "find_in_set(".$data['se_category_id'].", se_category_id)";
        }
        if(!empty($data['category_id'])) {
            $datas[] = 'category_id = '.$data['category_id'];
        }
        if(!empty($data['se_city_id'])) {
            $datas[] = 'se_city_id = '.$data['se_city_id'];
        }
        $datas[] = 'status=1';
        $result = $this->where(implode(' AND ', $datas))
            ->order($order)
            ->paginate(1);
        //echo $this->getLastSql();
        return $result;
    }
    public function updateBuyCountById($id, $buyCount)
    {
        return $this->where(['id' => $id])->setInc('buy_count', $buyCount);//自增
    }
}