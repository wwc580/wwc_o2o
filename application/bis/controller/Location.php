<?php
namespace app\bis\controller;

use tests\thinkphp\library\think\cache\driver\memcachedTest;
use think\Controller;
use think\Loader;

class Location extends Base
{
    /**
     * 列表页
     * @return mixed
     */
    public function index()
    {
        $bisId = $this->getLoginUser()->bis_id;
        $location = model('BisLocation')->getBisLocationByBisId($bisId);
        return $this->fetch('',[
            'location' => $location,
        ]);
    }
    public function add()
    {
        if(request()->isPost()) {
            $data = input('post.');
            //校验
            $validate = validate('Location');
            if(!$validate->scene('add')->check($data)) {
                $this->error($validate->getError());
            }

            $bisId = $this->getLoginUser()->bis_id;
            //获取经纬度
            $lnglat = \Map::getLngLat($data['address']);
            if(empty($lnglat)|| $lnglat['status']!=0 || $lnglat['result']['precise']!=1) {
                $this->error('无法获取数据，或者匹配的地址不精确');
            }
            $data['cat'] = '';
            if(!empty($data['se_category_id'])) {
                //数组分割
                $data['cat'] = implode('|', $data['se_category_id']);
            }
            //门店入库
            $locationData = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'logo' => $data['logo'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id'] . ',' . $data['cat'],
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
                'api_address' => $data['address'],
                'open_time' => $data['open_time'],
                'content' => empty($data['content']) ? '' :$data['content'],
                'is_main' => 0,
                'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
                'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
            ];
            $locationId = model('BisLocation')->add($locationData);
            if($locationId) {
                return $this->success('门店申请成功');
            }else {
                return $this->error('门店申请失败');
            }
        }else {
            //获取一级城市的数据
            $citys = model('City')->getNormalCityByParentId();
            //获取一级分类的数据
            $categorys = model('Category')->getNormalFirstCategory();
            return $this->fetch('', [
                'citys' => $citys,
                'categorys' => $categorys,
            ]);
        }
    }

    public function detail()
    {
        $id = input('get.id');
        //校验
        $validate = validate('Location');
        if(!$validate->scene('detail')->check($id)) {
            $this->error($validate->getError());
        }
        $location = model('BisLocation')->get($id);
        //获取一级城市的数据
        $citys = model('City')->getNormalCityByParentId();
        //获取一级分类的数据
        $categorys = model('Category')->getNormalFirstCategory();
        return $this->fetch('', [
            'citys' => $citys,
            'categorys' => $categorys,
            'location' => $location,
        ]);
    }

    public function status()
    {
        $data = input('get.');
        //校验
        $validate = validate('Location');
        if(!$validate->scene('status')->check($data)) {
            $this->error($validate->getError());
        }
        $res = model('BisLocation')->save(['status' => $data['status']], ['id' => $data['id']]);
        if($res) {
            return $this->success('状态更新成功');
        }else {
            return $this->error('状态更新失败');
        }
    }
}
