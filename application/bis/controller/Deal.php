<?php
namespace app\bis\controller;

use tests\thinkphp\library\think\cache\driver\memcachedTest;
use think\Controller;

class Deal extends Base
{
    public function index()
    {
        $deal = model('Deal')->getDealByStatus(['in', '0,1']);
        return $this->fetch('', [
            'deal' => $deal,
        ]);
    }
    public function add()
    {
        $bisId = $this->getLoginUser()->bis_id;
        if(request()->isPost()) {
            $data = input('post.');
            //校验
            $validate = validate('Deal');
            if(!$validate->scene('add')->check($data)) {
                $this->error($validate->getError());
            }
            $location = model('BisLocation')->get($data['location_ids'][0]);
            $deals = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'image' => $data['image'],
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'description' => $data['description'],
                'notes' => $data['notes'],
                'location_ids' => empty($data['location_ids']) ? '' : implode(',', $data['location_ids']),
                'se_category_id' => empty($data['se_category_id']) ? '' : implode(',', $data['se_category_id']),
                'category_id' => $data['category_id'],
                'city_id' => $data['city_id'],
                'se_city_id' => $data['se_city_id'],
                'bis_account_id' => $this->getLoginUser()->id,
                'xpoint' => $location->xpoint,
                'ypoint' => $location->ypoint,
            ];
            $id = model('Deal')->add($deals);
            if($id) {
                return $this->success('添加成功', url('deal/index'));
            }else {
                return $this->error('添加失败');
            }
        }else {
            //获取一级城市的数据
            $citys = model('City')->getNormalCityByParentId();
            //获取一级分类的数据
            $categorys = model('Category')->getNormalFirstCategory();
            return $this->fetch('', [
                'citys' => $citys,
                'categorys' => $categorys,
                'bislocations' => model('BisLocation')->getNormalLocationByBisId($bisId),
            ]);
        }
    }
    public function detail()
    {
        $id = input('get.id');
        $validate = validate('Deal');
        if(!$validate->scene('detail')->check($id)) {
            $this->error($validate->getError());
        }
        $deal = model('Deal')->get($id);
        $bisId = $this->getLoginUser()->bis_id;
        //获取一级城市的数据
        $citys = model('City')->getNormalCityByParentId();
        //获取一级分类的数据
        $categorys = model('Category')->getNormalFirstCategory();
        return $this->fetch('', [
            'citys' => $citys,
            'categorys' => $categorys,
            'bislocations' => model('BisLocation')->getNormalLocationByBisId($bisId),
            'deal' => $deal,
        ]);
    }
    public function status()
    {
        $data = input('get.');
        $validate = validate('Deal');
        if(!$validate->scene('status')->check($data)) {
            $this->error($validate->getError());
        }
        $res = model('Deal')->save(['status' =>$data['status']], ['id' => $data['id']]);
        if($res) {
            return $this->success('更新状态成功');
        }else {
            return $this->error('更新状态失败');
        }
    }
}
