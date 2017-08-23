<?php
namespace app\admin\controller;
use think\Controller;
use think\Validate;

/**
 * 公共控制器
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller
{

    public function status()
    {
        $data = input('get.');
        //获取控制器
        $model = request()->controller();
        //echo $model;exit; Featured
        $validate = validate($model);
        if(!$validate->scene('status')->check($data)) {
            $this->error($validate->getError());
        }
        $res = model($model)->save(['status' => $data['status']], ['id' => $data['id']]);
        if($res) {
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }
    }

}
