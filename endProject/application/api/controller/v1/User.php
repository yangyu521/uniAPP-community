<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use app\common\controller\BaseController;
use app\common\validate\UserValidate;
use app\common\model\User as UserModel;

class User extends BaseController
{   //发送验证码
    public function sendCode()
    {
        //验证参数
        (new UserValidate())->goCheck('scendCode');
        (new UserModel())->sendCode();
        return self::showResCodeWithOutData('发送成功');
    }

    // 手机号码登录
    public function phoneLogin()
    {
        // 验证登录信息
        (new UserValidate())->goCheck('phonelogin');
        // // 手机登录
        $token = (new UserModel())->phoneLogin();
        return self::showResCode('登录成功', ['token'=>$token]);
    }
    // 账号密码登录
    public function login()
    {
        // 验证登录信息
        (new UserValidate())->goCheck('login');
        // 登录
        $token = (new UserModel())->login();
        return self::showResCode('登录成功', ['token'=>$token]);
    }
    // 第三方登录
    public function otherLogin()
    {
        // 验证登录信息
        (new UserValidate())->goCheck('otherlogin');
        $token = (new UserModel())->otherlogin();
        return self::showResCode('登录成功', ['token'=>$token]);
    }
    public function logout()
    {
        // 验证用户是否有访问该接口的权限
        //验证用户参数
        (new UserModel())->logout();
        return self::showResCodeWithOutData('退出成功');
    }
    // 用户发布文章列表
    public function post()
    {
        (new UserValidate())->goCheck('post');
        $list = (new UserModel())->getPostList();
        return self::showResCode('获取成功', ['list'=>$list]);
    }
    // 用户发布文章列表
    public function Allpost()
    {
        (new UserValidate())->goCheck('allpost');
        $list = (new UserModel())->getAllPostList();
        return self::showResCode('获取成功', ['list'=>$list]);
    }
    // 绑定手机
    public function bindphone()
    {
        (new UserValidate())->goCheck('bindphone');
        // 绑定
        (new UserModel())->bindphone();
        return self::showResCodeWithOutData('绑定成功');
    }
    // 绑定邮箱
    public function bindemail()
    {
        (new UserValidate())->goCheck('bindemail');
        // 绑定
        (new UserModel())->bindemail();
        return self::showResCodeWithOutData('绑定成功');
    }
    // 绑定第三方
    public function bindother()
    {
        (new UserValidate())->goCheck('bindother');
        (new UserModel())->bindother();
        return self::showResCodeWithOutData('绑定成功');
    }
}
