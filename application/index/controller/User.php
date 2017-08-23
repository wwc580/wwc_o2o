<?php
namespace app\index\controller;
use think\Controller;
class User extends Controller
{
    public function login()
    {
        //获取session
        $user = session('o2o_user', '', 'o2o');
        if($user && $user->id) {
            return $this->redirect('index/index');
        }else {
            return $this->fetch();
        }
    }
    public function register()
    {
        if(request()->isPost()) {
            $data = input('post.');
            /*if(!captcha_check($data['verifyCode'])) {
                $this->error('验证码不正确');
            }*/
            $validate = validate('User');
            if(!$validate->scene('register')->check($data)) {
                $this->error($validate->getError());
            }
            //自动生成加盐字符串
            $data['code'] = mt_rand(100, 10000);
            $data['password'] = md5($data['password'].$data['code']);

            try {
                $res = model('User')->add($data);
            }catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            if($res) {
                return $this->success('注册成功', url('user/login'));
            }else {
                return $this->error('注册失败');
            }
        }else {
            return $this->fetch();
        }
    }
    public function logincheck()
    {
        if(!request()->isPost()) {
            $this->error('提交不合法');
        }
        $data = input('post.');
        //校验
        $validate = validate('User');
        if(!$validate->scene('login')->check($data)) {
            $this->error($validate->getError());
        }
        //$user = model('User')->getUserByUsername($data['username']);
        $user = model('User')->get(['username' => $data['username']]);

        if(!$user || $user->status != 1) {
            $this->error('该用户不存在');
        }
        if(md5($data['password'].$user->code) != $user->password) {
            $this->error('密码不正确');
        }
        //model('User')->updateById(['last_login_time' => time()], $user->id);
        model('User')->save(['last_login_time' => time()], ['id' => $user->id]);
        session('o2o_user', $user, 'o2o');
        return $this->success('登录成功', url('index/index'));
    }
    public function logout()
    {
        //清空session
        session(null, 'o2o');
        return $this->redirect('user/login');
    }
}
