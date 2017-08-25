<?php
namespace app\index\controller;
use think\Controller;
class Lists extends Base
{
    public function index()
    {
        $firstCatIds = [];
        $categorys = model('Category')->getNormalCategoryByParentId();
        foreach($categorys as $category) {
            $firstCatIds[] = $category->id;
        }
        $data = [];
        $id = input('get.id', 0, 'intval');
        //id 0 一级分类 二级分类
        if(in_array($id, $firstCatIds)) {
            //一级分类
            $categoryParentId = $id;
            $data['category_id'] = $id;
        }else if($id) {
            //二级分类
            //获取二级分类
            $category = model('Category')->get($id);
            if(!$category || $category->status != 1) {
                $this->error('数据不合法');
            }
            $categoryParentId = $category->parent_id;
            $data['se_category_id'] = $id;
        }else {
            $categoryParentId = 0;
        }
        //获取父类下的所有子分类
        $sedcategorys = [];
        $sedcategorys = model('Category')->getNormalCategoryByParentId($categoryParentId);

        //排序
        $orders = [];
        $order_sales = input('get.order_sales', '');
        $order_price = input('get.order_price', '');
        $order_time = input('get.order_time', '');
        if(!empty($order_sales)) {
            $orderflag = 'order_sales';
            $orders['order_sales'] = $order_sales;
        }else if(!empty($order_price)) {
            $orderflag = 'order_price';
            $orders['order_price'] = $order_price;
        }else if(!empty($order_time)) {
            $orderflag = 'order_time';
            $orders['order_time'] = $order_time;
        }else {
            $orderflag = '';
        }
        $data['se_city_id'] = $this->city->id;
        //根据上面条件查询商品数据
        $deals = model('Deal')->getDealByConditions($data, $orders);
        return $this->fetch('', [
            'categorys' => $categorys,
            'sedcategorys' => $sedcategorys,
            'id' => $id,
            'categoryParentId' => $categoryParentId,
            'orderflag' => $orderflag,
            'deals' => $deals,
        ]);
    }
}
