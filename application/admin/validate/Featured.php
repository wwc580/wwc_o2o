<?php
namespace app\admin\validate;
use think\Validate;
class Featured extends Validate
{
    protected $rule = [
        ['title', 'max:30|require'],
        ['image', 'require'],
        ['type', 'number|require'],
        ['url', 'url'],
        ['description', 'max:255'],
        ['id', 'number|require'],
        ['status', 'number|in:-1,1,0', '状态必须是数字|状态范围不合法'],
    ];
    /**
     * 场景设置
     */
    protected $scene = [
        'add' => ['title', 'image', 'type', 'url', 'description'],//添加
        'status' => ['id', 'status'],//修改状态
    ];
}