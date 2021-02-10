<?php

namespace app\common\validate;

use think\Validate;

class UserValidate extends BaseValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'phone'=>'require|mobile',
        'code'=>'require|number|length:4|isPefectCode',
        'provider'=>'require',
        'openid'=>'require',
        'nickName'=>'require',
        'avatarUrl'=>'require',
        'expires_in'=>'require',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'phone.require'=>'请填写手机号码',
        'phone.mobile'=>'手机号码不合法',
        'username'=>'require',
        'password'=>'require|alphaDash',
        'id'=>'require|integer|>:0',
        'page'=>'require|integer|>:0',
        'email'=>'require|email',
    ];
    //配置场景
    protected $scene = [
        'scendCode'=>['phone'],
        'phonelogin'=>['phone','code'],
        'login'=>['username','password'],
        'otherlogin'=>['provider','openid','nickName','avatarUrl','expires_in'],
        'post'=>['id','page'],
        'allpost'=>['page'],
        'bindphone'=>['phone','code'],
        'bindemail'=>['email'],
        'bindother'=>['provider','openid','nickName','avatarUrl'],
    ];
}
