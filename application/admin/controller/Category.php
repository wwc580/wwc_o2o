<?php
namespace app\admin\controller;
use think\Controller;
use think\Validate;

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
        $parentId = input('get.parent_id', 0, 'intval');
        $categorys = model('Category')->getFirstCategorys($parentId);
        return $this->fetch('',[
            'categorys' => $categorys,
        ]);
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
        /**
         * 校验post
         */
        if(!request()->isPost()) {
            $this->error('请求失败');
        }
        $data = input('post.');
        $validate = validate('Category');
        if(!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
        }
        /**
         * 判断编辑模式
         */
        if(!empty($data['id'])) {
            return $this->update($data);
        }
        //把$data 提交给model层
        $res = model('Category')->add($data);
        if($res) {
            $this->success('新增成功');
        }else {
            $this->error('新增失败');
        }
    }
    /**
     * 编辑模板
     */
    public function edit($id=0)
    {
        if(intval($id) < 0)
        {
            $this->error('参数不合法');
        }
        $category = model('Category')->get($id);//当表中id为主键id时 取得所有记录 返回对象 tp5
        $categorys = model('Category')->getNormalFirstCategory();
        return $this->fetch('', [
            'categorys' => $categorys,
            'category' => $category,
        ]);
    }
    /**
     * 编辑操作数据库
     */
    public function update($data)
    {
        $res = model('Category')->save($data, ['id' => intval($data['id'])]);
        if($res) {
            $this->success('更新成功');
        }else {
            $this->error('更新失败');
        }
    }
    /**
     * 排序
     */
    public function listorder($id, $listorder)
    {
        $validate = validate('Category');
        if(!$validate->scene('listorder')->check(['id' => $id, 'listorder' => $listorder])) {
            $this->error($validate->getError());
        }
        $res = model('Category')->save(['listorder' => $listorder], ['id' => $id]);
        if($res) {
            $this->result($_SERVER['HTTP_REFERER'], 1, 'success');//tp5自带
        }else {
            $this->result($_SERVER['HTTP_REFERER'], 0, '更新失败');
        }
    }
    public function status()
    {
        $data = input('get.');
        $validate = validate('Category');
        if(!$validate->scene('status')->check($data)) {
            $this->error($validate->getError());
        }
        $res = model('Category')->save(['status' => $data['status']], ['id' => intval($data['id'])]);
        if($res) {
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }
    }
}
