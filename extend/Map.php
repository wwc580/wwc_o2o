<?php
/**
 * 百度地图相关业务封装
 */
class Map
{
    /**
     * 根据地址获取经纬度
     * @param $address
     * @return array
     */
    public static function getLngLat($address)
    {
        if(!$address) {
            return '';
        }
        //http://api.map.baidu.com/geocoder/v2/?callback=renderOption&output=json&address=百度大厦&city=北京市&ak=您的ak

        $data = [
            'address' => $address,
            'ak' => config('map.ak'),//读取app/extra/map.php的配置
            'output' => 'json',
        ];
        $url = config('map.baidu_map_url').config('map.geocoder').'?'.http_build_query($data);
        //读取url内容
        //1. file_get_contents($url);
        //2 curl
        $result = doCurl($url);
        if($result) {
            //返回数组
            return json_decode($result, true);
        }else {
            return [];
        }
    }

    /**
     * 根据经纬度或地址获取百度地图
     * @param $center
     */
    public static function staticimage($center)
    {
        if(!$center) {
            return '';
        }
        //http://api.map.baidu.com/staticimage/v2
        $data = [
            'ak' => config('map.ak'),//读取app/extra/map.php的配置
            'width' => config('map.width'),
            'height' => config('map.height'),
            'center' => $center,
            'markers' => $center,
        ];
        $url = config('map.baidu_map_url').config('map.staticimage').'?'.http_build_query($data);
        //读取url内容
        //1. file_get_contents($url);
        //2 curl
        $result = doCurl($url);
        return $result;
    }
}