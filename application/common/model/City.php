<?php
namespace app\common\model;

use think\Model;

class City extends Model
{
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
        return $this->save($data);
    }
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
    public function getFirstCitys($parentId = 0)
    {
        $data = [
            'parent_id' => $parentId,
            'status' => ['neq', -1],
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        $result =  $this->where($data)
            ->order($order)
            ->paginate();//使用tp5分页 默认config.php 15
        //->select();
        //调试
        //echo $this->getLastSql();
        return $result;
    }
    public function getNormalFirstCity()
    {
        $data = [
            'status' => 1,
            'parent_id' => 0,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }
}