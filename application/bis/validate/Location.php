<?php
namespace app\bis\validate;
use think\Validate;
class Location extends Validate
{
    protected $rule = [
        ['id', 'number'],
        ['name', 'require|max:50'],
        ['logo', 'require'],
        ['tel', 'require|number'],
        ['contact', 'require|chsAlpha'],
        ['address', 'require'],
        ['open_time', 'require'],
        ['status', 'number|eq:-1', '状态必须是数字|状态范围不合法'],

    ];
    /**
     * 场景设置
     */
    protected $scene = [
        'add' => ['name', 'logo', 'tel','contact','address','open_time'],//添加
        'detail' => ['id'],//查看
        'status' => ['id', 'status'],//状态
    ];
}