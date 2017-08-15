<?php
namespace app\admin\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function test()
    {
        \Map::getLngLat('南京火车站');
    }
    public function map()
    {
        //<img style="margin:20px" width="400" height="300" src="{:url('index/map')}" />
        return \Map::staticimage('南京火车站');
    }
    public function welcome()
    {
        /*\phpmailer\Email::send('1499592453@qq.com', '测试一下', '没有正文');
        return '发送成功';*/
        return "欢迎来到主后台首页";
    }
}
