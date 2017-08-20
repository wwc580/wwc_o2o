<?php
namespace app\common\model;

use think\Model;

class BisLocation extends Model
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
        $data['status'] = 0;
        //$data['create_time'] = time();
        $this->save($data);
        //返回主键id
        return $this->id;
    }

}