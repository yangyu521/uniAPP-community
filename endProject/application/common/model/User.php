<?php

namespace app\common\model;

use think\Model;
use think\facade\Cache;
use app\lib\exception\BaseException;

class User extends Model
{
    // 自动写入时间
    protected $autoWriteTimestamp = true;
    // 绑定用户信息表
    public function userinfo()
    {
        return $this->hasOne('Userinfo');
    }
    // 绑定第三方登录
    public function userbind()
    {
        return $this->hasMany('UserBind');
    }

    // 发送验证码
    public function sendCode()
    {
        // 获取用户提交手机号码
        $phone = request()->param('phone');
        // 判断是否已经发送过
        if (Cache::get($phone)) {
            throw new BaseException(['code'=>200,'msg'=>'你操作得太快了','errorCode'=>30001]);
        }
        // 生成4位验证码
        $code = random_int(1000, 9999);
        // 判断是否开启验证码功能
        if (!config('api.aliSMS.isopen')) {
            Cache::set($phone, $code, config('api.aliSMS.expire'));
            throw new BaseException(['code'=>200,'msg'=>'验证码：'.$code,'errorCode'=>30005]);
        }
        // 发送验证码
        $res = AlismsController::SendSMS($phone, $code);
        //发送成功 写入缓存
        if ($res['Code']=='OK') {
            return Cache::set($phone, $code, config('api.aliSMS.expire'));
        }
        // 无效号码
        if ($res['Code']=='isv.MOBILE_NUMBER_ILLEGAL') {
            throw new BaseException(['code'=>200,'msg'=>'无效号码','errorCode'=>30002]);
        }
        // 触发日限制
        if ($res['Code']=='isv.DAY_LIMIT_CONTROL') {
            throw new BaseException(['code'=>200,'msg'=>'今日你已经发送超过限制，改日再来','errorCode'=>30003]);
        }
        // 发送失败
        throw new BaseException(['code'=>200,'msg'=>'发送失败','errorCode'=>30004]);
    }

    // 账号登录
    public function login()
    {
        // 获取所有参数
        $param = request()->param();
        // 验证用户是否存在
        $user = $this->isExist($this->filterUserData($param['username']));
        // 用户不存在
        if (!$user) {
            throw new BaseException(['code'=>200,'msg'=>'昵称/邮箱/手机号错误','errorCode'=>20000]);
        }
        // 用户是否被禁用
        $this->checkStatus($user->toArray());
        // 验证密码
        $this->checkPassword($param['password'], $user->password);
        // 登录成功 生成token，进行缓存，返回客户端
        return $this->CreateSaveToken($user->toArray());
    }

    // 验证用户名是什么格式，昵称/邮箱/手机号
    public function filterUserData($data)
    {
        $arr=[];
        // 验证是否是手机号码
        if (preg_match('^1(3|4|5|7|8)[0-9]\d{8}$^', $data)) {
            $arr['phone']=$data;
            return $arr;
        }
        // 验证是否是邮箱
        if (preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/', $data)) {
            $arr['email']=$data;
            return $arr;
        }
        $arr['username']=$data;
        return $arr;
    }

    // 验证密码
    public function checkPassword($password, $hash)
    {
        if (!$hash) {
            throw new BaseException(['code'=>200,'msg'=>'密码错误','errorCode'=>20002]);
        }
        // 密码错误
        if (!password_verify($password, $hash)) {
            throw new BaseException(['code'=>200,'msg'=>'密码错误','errorCode'=>20002]);
        }
        return true;
    }

    // 判断用户是否存在（在前面课程的基础上扩充）
    public function isExist($arr=[])
    {
        if (!is_array($arr)) {
            return false;
        }
        if (array_key_exists('phone', $arr)) { // 手机号码
            return $this->where('phone', $arr['phone'])->find();
        }
        // 用户id
    if (array_key_exists('id', $arr)) { // 用户名
        return $this->where('id', $arr['id'])->find();
    }
        if (array_key_exists('email', $arr)) { // 邮箱
            return $this->where('email', $arr['email'])->find();
        }
        if (array_key_exists('username', $arr)) { // 用户名
            return $this->where('username', $arr['username'])->find();
        }
        // 第三方参数
        if (array_key_exists('provider', $arr)) {
            $where = [
            'type'=>$arr['provider'],
            'openid'=>$arr['openid']
        ];
            return $this->userbind()->where($where)->find();
        }
        return false;
    }
    // 手机登录
    public function phoneLogin()
    {
        // 获取所有参数
        $param = request()->param();
        // 验证用户是否存在
        $user = $this->isExist(['phone'=>$param['phone']]);
        // 用户不存在，直接注册
        if (!$user) {
            // 用户主表
            $user = self::create([
                    'username'=>$param['phone'],
                    'phone'=>$param['phone'],
                     'password'=>password_hash($param['phone'], PASSWORD_DEFAULT)
                ]);
            // 在用户信息表创建对应的记录（用户存放用户其他信息）
            $user->userinfo()->create([ 'user_id'=>$user->id ]);
            return $this->CreateSaveToken($user->toArray());
        }
        // 用户是否被禁用
        $this->checkStatus($user->toArray());
        // 登录成功，返回token
        return $this->CreateSaveToken($user->toArray());
    }

    // 生成并保存token
    public function CreateSaveToken($arr=[])
    {
        // 生成token
        $token = sha1(md5(uniqid(md5(microtime(true)), true)));
        $arr['token'] = $token;
        // 登录过期时间
        $expire =array_key_exists('expires_in', $arr) ? $arr['expires_in'] : config('api.token_expire');
        // 保存到缓存中
        if (!Cache::set($token, $arr, $expire)) {
            throw new BaseException();
        }
        // 返回token
        return $token;
    }

    // 用户是否被禁用（在前面课程基础上扩展）
    public function checkStatus($arr, $isReget = false)
    {
        $status = 1;
        if ($isReget) {
            // 账号密码登录 和 第三方登录
            $userid = array_key_exists('user_id', $arr)?$arr['user_id']:$arr['id'];
            // 判断第三方登录是否绑定了手机号码
            if ($userid < 1) {
                return $arr;
            }
            // 查询user表
            $user = $this->find($userid)->toArray();
            // 拿到status
            $status = $user['status'];
        } else {
            $status = $arr['status'];
        }
        if ($status==0) {
            throw new BaseException(['code'=>200,'msg'=>'该用户已被禁用','errorCode'=>20001]);
        }
        return $arr;
    }

   


    // 第三方登录
    public function otherlogin()
    {
        // 获取所有参数
        $param = request()->param();
        // 解密过程（待添加）
        // 验证用户是否存在
        $user = $this->isExist(['provider'=>$param['provider'],'openid'=>$param['openid']]);
        // 用户不存在，创建用户
        $arr = [];
        if (!$user) {
            $user = $this->userbind()->create([
            'type'=>$param['provider'],
            'openid'=>$param['openid'],
            'nickname'=>$param['nickName'],
            'avatarurl'=>$param['avatarUrl'],
        ]);
            $arr = $user->toArray();
            $arr['expires_in'] = $param['expires_in'];
            return $this->CreateSaveToken($arr);
        }
        // 用户是否被禁用
        $arr = $this->checkStatus($user->toArray(), true);
        // 登录成功，返回token
        $arr['expires_in'] = $param['expires_in'];
        return $this->CreateSaveToken($arr);
    }
    // 验证第三方登录是否绑定手机
    public function OtherLoginIsBindPhone($user)
    {
        // 验证是否是第三方登录
        if (array_key_exists('type', $user)) {
            if ($user['user_id']<1) {
                throw new BaseException(['code'=>200,'msg'=>'请先绑定手机！','errorCode'=>20008]);
            }
            return $user['user_id'];
        }
        // 账号密码登录
        return $user['id'];
    }
    // 退出登录
    public function logout()
    {
        if (!Cache::pull(request()->userToken)) {
            TApiException('你已经退出了', 30006);
        }
        return true;
    }
    // 关联文章
    public function post()
    {
        return $this->hasMany('Post');
    }
    // 获取指定用户下文章
    public function getPostList()
    {
        $params = request()->param();
        $user = $this->get($params['id']);
        if (!$user) {
            TApiException('该用户不存在', 10000);
        }
        return $user->post()->with([
            'user'=>function ($query) {
                return $query->field('id,username,userpic');
            },'images'=>function ($query) {
                return $query->field('url');
            },'share'])->where('isopen', 1)->page($params['page'], 10)->select();
    }
    // 获取指定用户下所有文章
    public function getAllPostList()
    {
        $params = request()->param();
        // 获取用户id
        $user_id=request()->userId;
        return $this->get($user_id)->post()->with([
        'user'=>function ($query) {
            return $query->field('id,username,userpic');
        },'images'=>function ($query) {
            return $query->field('url');
        },'share'])->page($params['page'], 10)->select();
    }
}
