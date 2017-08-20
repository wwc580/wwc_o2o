<?php
namespace app\admin\controller;
use think\Controller;
use think\Validate;

class Bis extends Controller
{
    /**
     * 初始化模型方法如下
     */
    private $obj;
    public function _initialize()
    {
        $this->obj = model('Bis');
    }

    /**
     * 入驻申请列表
     * @return mixed
     */
    public function apply()
    {
        $bis = $this->obj->getBisByStatus();
        return $this->fetch('',[
            'bis' => $bis,
        ]);
    }

    /**
     * 查看详情
     * @return mixed|void
     */
    public function detail()
    {
        $id = input('get.id');
        if(empty($id)) {
            return $this->error('ID错误');
        }
        //获取一级城市的数据
        $citys = model('City')->getNormalCityByParentId();
        //获取一级分类的数据
        $categorys = model('Category')->getNormalFirstCategory();

        //获取商户数据
        $bisData = $this->obj->get($id);
        $locationData = model('BisLocation')->get([
            'bis_id' => $id,
            'is_main' => 1,
        ]);
        $accountData = model('BisAccount')->get([
            'bis_id' => $id,
            'is_main' => 1,
        ]);
        return $this->fetch('', [
            'citys' => $citys,
            'categorys' => $categorys,
            'bisData' => $bisData,
            'locationData' => $locationData,
            'accountData' => $accountData,
        ]);
    }
    public function status()
    {
        $data = input('get.');
        $validate = validate('Bis');
        if(!$validate->scene('status')->check($data)) {
            $this->error($validate->getError());
        }
        $res = model('Bis')->save(['status' => $data['status']], ['id' => $data['id']]);
        $location = model('BisLocation')->save(['status' => $data['status']], ['bis_id' => $data['id']]);
        $account = model('BisAccount')->save(['status' => $data['status']], ['bis_id' => $data['id']]);
        if($res && $location && $account) {
            //发送邮件
            //status 1通过 2不通过 -1删除
            switch ($data['status']) {
                case 1:
                    $content = '恭喜您，入驻申请通过';
                    break;
                case 2:
                    $content = '抱歉，您的入驻申请未通过审核，请尽快修改完善';
                    break;
                case -1:
                    $content = '抱歉，您的入驻申请失败';
                    break;
            }
            $title = 'o2o入驻申请通知';
            \phpmailer\Email::send($data['email'], $title, $content);
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }
    }

}
