<?php
namespace app\admin\validate;
use think\Validate;
class City extends Validate
{
    protected $rule = [
        ['name', 'require|max:10', '分类名必须传递|分类名不能超过10个字符'],
        ['uname', 'require|alpha'],
        ['parent_id', 'number'],
        ['id', 'number'],
    ];
    /**
     * 场景设置
     */
    protected $scene = [
        'add' => ['name', 'parent_id', 'id','uname'],//添加 有这个字段值才会校验
    ];
}