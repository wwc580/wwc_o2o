<?php
namespace app\common\model;

use think\Model;

class User extends BaseModel
{
    public function add($data = [])
    {
        if(!is_array($data)) {
            //抛异常
            exception('传递的数据不是数组');
        }
        $data['status'] = 1;
        //allowField 过滤data数组中非数据表中的数据
        $id = $this->allowField(true)->save($data);
        return $id;
    }

    /**
     * 根据用户名获取用户信息
     * @param $username
     */
    public function getUserByUsername($username)
    {
        if(!$username) {
            exception('用户名不合法');
        }
        $data = [
            'username' => $username,
        ];
        return $this->where($data)->find();
    }

    public function updateById($data=[], $id)
    {
        return $this->allowField(true)->save($data, ['id' => $id]);
    }
}