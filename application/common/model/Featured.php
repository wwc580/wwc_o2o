<?php
namespace app\common\model;

use think\Model;

class Featured extends BaseModel
{
    public function getFeaturedByType($type)
    {
        $data = [
            'status' => ['neq', -1],
            'type' => $type,
        ];
        $order = [
            'id' => 'desc',
        ];
        $result = $this->where($data)
            ->order($order)
            ->paginate(1);
        return $result;
    }
    public function getNormalFeaturedByType($type)
    {
        $data = [
            'status' => 1,
            'type' => $type,
        ];
        return $this->where($data)->select();
    }
}