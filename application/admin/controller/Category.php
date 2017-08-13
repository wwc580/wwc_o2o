<?php
namespace app\admin\controller;
use think\Controller;
class Category extends Controller
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
        return $this->fetch();
    }
    public function add()
    {
        $categorys = model('Category')->getNormalFirstCategory();
        //$categorys = $this->obj->getNormalFirstCategory();
        return $this->fetch('', [
            'categorys' => $categorys,
        ]);
    }
    public function save()
    {
        //print_r(input('post.'));
        //print_r(request()->post());
        $data = input('post.');
        $validate = validate('Category');
        if(!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
        }
        //把$data 提交给model层
        $res = model('Category')->add($data);
        if($res) {
            $this->success('新增成功');
        }else {
            $this->error('新增失败');
        }
    }
}
