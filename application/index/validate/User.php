<?php
namespace app\index\validate;

use think\Validate;
class User extends Validate
{
    protected $rule = [
        ['username', 'chsDash|require'],
        ['email', 'email|require'],
        ['password', 'alphaNum|require'],
        ['repassword', 'confirm:password|require'],
        ['verifycode', 'captcha|require'],
    ];
    /**
     * 场景设置
     */
    protected $scene = [
        'register' => ['username', 'password', 'email', 'repassword', 'verifycode'],//修改状态
        'login' => ['username', 'password'],//修改状态
    ];
}