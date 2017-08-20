<?php
namespace app\bis\controller;

use think\Controller;

class Login extends Controller
{
    public function index()
    {
        if(request()->isPost()) {
            //登录
            //获取数据
            $data = input('post.');
            //校验
            $validate = validate('Bis');
            if(!$validate->scene('login')->check($data)) {
                $this->error($validate->getError());
            }
            //通过用户名 获取用户相关信息
            $ret = model('BisAccount')->get(['username' => $data['username']]);
            if(!$ret || $ret->status != 1) {
                $this->error('改用户不存在，或者用户未被审核通过');
            }
            if($ret->password != md5($data['password'].$ret->code)) {
                $this->error('密码不正确');
            }

            model('BisAccount')->updateById(['last_login_time' => time()], $ret->id);
            //保存用户信息
            session('bisAccount', $ret, 'bis');//名 值 作用域
            return $this->success('登录成功', url('index/index'));
        }else {
            //获取session
            $account = session('bisAccount', '', 'bis');
            if($account && $account->id) {
                return $this->redirect('bis/index/index');
            }else {
                return $this->fetch();
            }
        }
    }
    public function logout()
    {
        //清除session
        session(null, 'bis');
        return $this->redirect('login/index');
    }
}