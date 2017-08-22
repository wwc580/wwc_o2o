<?php
namespace app\bis\validate;
use think\Validate;
class Deal extends Validate
{
    protected $rule = [
        ['id', 'number'],
        ['name', 'require|max:50'],
        ['image', 'require'],
        ['start_time', 'require|date'],
        ['end_time', 'require|date|gt:start_time'],
        ['total_count', 'require|number'],
        ['origin_price', 'require|number'],
        ['current_price', 'require|number'],
        ['coupons_begin_time', 'require|date'],
        ['coupons_end_time', 'require|date|gt:coupons_begin_time'],
        ['location_ids', 'array'],
        ['se_category_id', 'array'],
        ['category_id', 'number|require'],
        ['city_id', 'number|require'],
        ['status', 'number|eq:-1', '状态必须是数字|状态范围不合法'],

    ];
    /**
     * 场景设置
     */
    protected $scene = [
        'add' => ['name', 'image', 'start_time','end_time','total_count','origin_price','current_price','coupons_begin_time','coupons_end_time','location_ids','se_category_id','category_id','city_id'],//添加
        'detail' => ['id'],//查看
        'status' => ['id', 'status'],//状态
    ];
}