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
}