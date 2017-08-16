<?php
namespace app\api\controller;

use think\Controller;

class City extends Controller
{
    public function getCitysByParentId($id)
    {
        if(!$id) {
            $this->error('ID不合法');
        }
        $citys = model('City')->getNormalCityByParentId($id);
        if(!$citys) {
            return show(0, 'error');
        }
        return show(1, 'success', $citys);
    }
}