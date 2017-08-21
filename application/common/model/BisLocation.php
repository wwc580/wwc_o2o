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
    public function getBisLocationByStatus($status=0)
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
}