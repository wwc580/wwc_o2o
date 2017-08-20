<?php
namespace app\admin\validate;
use think\Validate;
class Bis extends Validate
{
    protected $rule = [
        ['id', 'number|require'],
        ['status', 'number|in:-1,1,2', '状态必须是数字|状态范围不合法'],
        ['email', 'email|require'],
    ];
    /**
     * 场景设置
     */
    protected $scene = [
        'status' => ['id', 'status', 'email'],//修改状态
    ];
}