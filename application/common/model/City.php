<?php
namespace app\common\model;

use think\Model;

class City extends Model
{
    public function getNormalCityByParentId($parentId = 0)
    {
        $data = [
            'status' => 1,
            'parent_id' => $parentId,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->select();
    }

    /**
     * 获取正常的市
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNormalCitys()
    {
        $data = [
            'status' => 1,
            'parent_id' => ['gt', 0],
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }
}