<?php
namespace app\common\model;

use think\Model;

class BisLocation extends BaseModel
{
    /**
     * 根据状态获取门店信息
     * @param int $status
     * @return \think\Paginator
     */
    public function getBisLocationByBisId($bisId)
    {
        $order = [
            'id' => 'desc',
        ];
        $data = [
            'status' => ['in', '0,1'],
            'bis_id' => $bisId,
        ];
        $result = $this->where($data)
            ->order($order)
            ->paginate(1);
        return $result;
    }
    public function getNormalLocationByBisId($bisId)
    {
        $data = [
            'bis_id' => $bisId,
            'status' => 1,
        ];
        $result = $this->where($data)
            ->order('id', 'desc')
            ->select();
        return $result;
    }
    public function getNormalLocationsInId($ids)
    {
        $data = [
            'id' => ['in', $ids],
            'status' => 1,
        ];
        return $this->where($data)->select();
    }
}