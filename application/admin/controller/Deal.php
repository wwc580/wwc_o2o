<?php
namespace app\admin\controller;
use think\Controller;
use think\Validate;

class Deal extends Controller
{

    public function index()
    {
        $data = input('get.');
        $sdata = [];
        if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time']) > strtotime($data['start_time'])) {
            $sdata['start_time'] = ['egt', strtotime($data['start_time'])];
            $sdata['end_time'] = ['elt', strtotime($data['end_time'])];
        }
        if(!empty($data['category_id'])) {
            $sdata['category_id'] = $data['category_id'];
        }
        if(!empty($data['city_id'])) {
            $sdata['se_city_id'] = $data['city_id'];
        }
        if(!empty($data['name'])) {
            $sdata['name'] = ['like', '%'.$data['name'].'%'];
        }

        $deals = model('Deal')->getNormalDeals($sdata);
        $categorys = model('Category')->getNormalCategoryByParentId();
        $citys = model('City')->getNormalCitys();
        return $this->fetch('',[
            'categorys' => $categorys,
            'citys' => $citys,
            'deals' => $deals,
            'category_id' => empty($data['category_id']) ? '' : $data['category_id'],
            'city_id' => empty($data['city_id']) ? '' : $data['city_id'],
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'name' => empty($data['name']) ? '' : $data['name'],
        ]);
    }

}
