<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function status($status)
{
    if($status == 1) {
        $str = "<span class='label label-success radius'>正常</span>";
    }else if($status == 0) {
        $str = "<span class='label label-danger radius'>待审</span>";
    }else {
        $str = "<span class='label label-danger radius'>删除</span>";
    }
    return $str;
}

function is_main($is_main){
    if($is_main == 1) {
        $str = "<span class='label label-success radius'>是</span>";
    }else if($is_main == 0) {
        $str = "<span class='label label-danger radius'>否</span>";
    }
    return $str;
}

/**
 * @param $url
 * @param int $type 0 get 1 post
 * @param array $data
 */
function doCurl($url, $type=0, $data=[])
{
    $ch = curl_init();//初始化
    curl_setopt($ch, CURLOPT_URL, $url);//设置选项
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//成功只返回结果
    curl_setopt($ch, CURLOPT_HEADER, 0);//不返回header

    if($type == 1) {
        //post
        curl_setopt($ch, CURLOPT_POST, 1);//设置post
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    //执行并获取内容
    $output = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    return $output;
}

/**
 * 商户入驻申请的文案
 */
function bisRegister($status)
{
    if($status == 1) {
        $str = '入驻申请成功';
    }else if($status == 0) {
        $str = '待审核，审核后平台方会发送邮件通知，请关注邮件';
    }else if($status == 2) {
        $str = '非常抱歉，您提交的材料不符合条件，请重新提交';
    }else {
        $str = '该申请已被删除';
    }
    return $str;
}

/**
 * 通用分页样式
 * @param $obj
 */
function pagination($obj)
{
    if(!$obj) {
        return '';
    }
    return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-o2o">'.$obj->render(). '</div>';
}

/**
 * 获取二级城市名
 * @param $path
 * @return string
 */
function getSeCityName($path)
{
    if(!$path) {
        return '';
    }
    if(preg_match('/,/', $path)) {
        $cityPath = explode(',', $path);
        $cityId = $cityPath[1];
    }else {
        $cityId = $path;
    }
    $city = model('City')->get($cityId);
    return $city->name;
}

function getSeCategory($path)
{
    if(!$path) {
        return '';
    }
    if(preg_match('/,/', $path)) {
        $categoryPath = explode(',', $path);
        $categoryId = $categoryPath[1];
    }else {
        $categoryId = $path;
    }

    $category = model('Category')->get($categoryId);
    return $category->name;
}
function countLocation($ids)
{
    if(preg_match('/,/', $ids)) {
        $arr = explode(',', $ids);
        return count($arr);
    }else {
       return 1;
    }
}