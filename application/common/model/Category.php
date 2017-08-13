<?php
namespace app\common\model;

use think\Model;

class Category extends Model
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
        return $this->save($data);
    }

    /**
     * 获取正常的一级分类
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNormalFirstCategory()
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