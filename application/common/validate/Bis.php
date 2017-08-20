<?php
namespace app\common\validate;
use think\Validate;
class Bis extends Validate
{
    protected $rule = [
        'name' => 'require|max:25',
        'email' => 'email',
        'logo' => 'require',
        'city_id' => 'require',
        'bank_info' => 'require',
        'username' => 'chsDash|max:30|min:2|require',
        'password' => 'chsAlphaNum|max:16|min:6|require',
    ];
    /**
     * 场景设置
     */
    protected $scene = [
        'add' => ['name'],//添加 有这个字段值才会校验
        'listorder' => ['id', 'listorder'],//排序
        'status' => ['id', 'status'],//修改状态
        'login' => ['username', 'password'],//登录
    ];
}