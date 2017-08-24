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
}