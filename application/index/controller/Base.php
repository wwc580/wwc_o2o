<?php
namespace app\index\controller;
use think\Controller;
class Base extends Controller
{
    public $city = '';
    public $account = '';
    public function _initialize()
    {
        /**
         * 公用数据初始化
         */
        //城市数据
        $citys = model('City')->getNormalCitys();
        $this->getCity($citys);
        //获取首页分类数据
        $cats = $this->getRecommendCats();
        $this->assign('citys', $citys);
        $this->assign('city', $this->city);
        $this->assign('cats', $cats);
        $this->assign('controller', strtolower(request()->controller()));//转换为小写
        $this->assign('user', $this->getLoginUser());
        $this->assign('title', 'o2o团购网');//默认title
    }
    public function getCity($citys)
    {
        foreach ($citys as $city) {
            $city = $city->toArray();
            if($city['is_default'] == 1) {
                $defaultuname = $city['uname'];
                break;//终止foreach
            }
        }
        $defaultuname = $defaultuname ? $defaultuname : 'nanchang';
        if(session('cityuname', '', 'o2o') && !input('get.city')) {
            $cityuname = session('cityuname', '', 'o2o');
        }else {
            $cityuname = input('get.city', $defaultuname, 'trim');
            session('cityuname', $cityuname, 'o2o');
        }
        $this->city = model('City')->where(['uname' => $cityuname])->find();
    }
    public function getLoginUser()
    {
        if(!$this->account) {
            $this->account = session('o2o_user', '', 'o2o');
        }
        return $this->account;
    }

    /**
     * 获取首页推荐的商品分类数据
     */
    public function getRecommendCats()
    {
        $parentIds = $sedcatArr = $recomCats = [];
        $cats = model('Category')->getNormalRecommendCategoryByParentId(0, 5);
        //dump($cats);exit; array[0]object
        foreach ($cats as $cat) {
            $parentIds[] = $cat->id;
        }
        //获取二级分类数据
        $sedCats = model('Category')->getNormalCategoryIdParentId($parentIds);
        foreach ($sedCats as $sedcat) {
            $sedcatsArr[$sedcat->parent_id][] = [
                'id' => $sedcat->id,
                'name' => $sedcat->name,
            ];
        }
        foreach ($cats as $cat) {
            //recomCats 整个一级分类二级分类数据 []第一个参数一级分类名 第二个参数 此一级分类下面所有的二级分类数据
            $recomCats[$cat->id] = [$cat->name, empty($sedcatsArr[$cat->id]) ? [] : $sedcatsArr[$cat->id]];
        }
        return $recomCats;
    }
}
