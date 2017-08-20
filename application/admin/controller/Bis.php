<?php
namespace app\admin\controller;
use think\Controller;
use think\Validate;

class Bis extends Controller
{
    /**
     * 初始化模型方法如下
     */
    private $obj;
    public function _initialize()
    {
        $this->obj = model('Bis');
    }

    /**
     * 入驻申请列表
     * @return mixed
     */
    public function apply()
    {
        $bis = $this->obj->getBisByStatus();
        return $this->fetch('',[
            'bis' => $bis,
        ]);
    }

    public function detail()
    {
        $id = input('get.id');
        if(empty($id)) {
            return $this->error('ID错误');
        }
        //获取一级城市的数据
        $citys = model('City')->getNormalCityByParentId();
        //获取一级分类的数据
        $categorys = model('Category')->getNormalFirstCategory();

        //获取商户数据
        $bisData = model('Bis')->get($id);
        $locationData = model('BisLocation')->get([
            'bis_id' => $id,
            'is_main' => 1,
        ]);
        $accountData = model('BisAccount')->get([
            'bis_id' => $id,
            'is_main' => 1,
        ]);
        return $this->fetch('', [
            'citys' => $citys,
            'categorys' => $categorys,
            'bisData' => $bisData,
            'locationData' => $locationData,
            'accountData' => $accountData,
        ]);
    }

}
