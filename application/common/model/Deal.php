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
}