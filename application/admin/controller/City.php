<?php
namespace app\admin\controller;
use think\Controller;
use think\Validate;

class City extends Controller
{
    /**
     * 初始化模型方法如下
     */
    /*private $obj;
    public function _initialize()
    {
        $this->obj = model('Category');
    }*/
    public function index()
    {
        $parentId = input('get.parent_id', 0, 'intval');
        $citys = model('City')->getFirstCitys($parentId);
        return $this->fetch('',[
            'citys' => $citys,
        ]);
    }
    public function add()
    {
        $citys = model('City')->getNormalFirstCity();
        return $this->fetch('', [
            'citys' => $citys,
        ]);
    }
    public function save()
    {
        //print_r(input('post.'));
        //print_r(request()->post());
        /**
         * 校验post
         */
        if(!request()->isPost()) {
            $this->error('请求失败');
        }
        $data = input('post.');
        $validate = validate('City');
        if(!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
        }

        //把$data 提交给model层
        $res = model('City')->add($data);
        if($res) {
            $this->success('新增成功');
        }else {
            $this->error('新增失败');
        }
    }

}
