<?php
namespace app\admin\controller;
use think\Controller;
use think\Validate;

class Featured extends Base
{

    public function index()
    {
        $type = input('get.type', 0, 'intval');
        $results = model('Featured')->getFeaturedByType($type);
        //获取推荐位类别
        $types = config('featured.featured_type');
        return $this->fetch('', [
            'types' => $types,
            'results' => $results,
            'type' => empty($type) ? 0 : $type,
        ]);
    }
    public function add()
    {
        if(request()->isPost()) {
            $data = input('post.', '', 'htmlentities');
            //校验
            $validate = validate('Featured');
            if(!$validate->scene('add')->check($data)) {
                $this->error($validate->getError());
            }
            $id = model('Featured')->add($data);
            if($id) {
                return $this->success('添加成功');
            }else {
                return $this->error('添加失败');
            }

        }else {
            //获取推荐位类别
            $types = config('featured.featured_type');
            return $this->fetch('', [
                'types' => $types,
            ]);
        }
    }

}
