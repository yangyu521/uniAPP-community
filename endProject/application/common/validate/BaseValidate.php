<?php
namespace app\common\validate;

use think\Validate;
use app\lib\exception\BaseException;

class BaseValidate extends Validate
{
    public function goCheck($scene = false)
    {
        //获取请求传递过来的所有参数
        $params = request()->param();
        //开始验证
        $check = $scene ?
         $this->scene($scene)->check($params):
         $this->check($params);
         
        if (!$check) {
            throw new BaseException(['msg'=>$this->getError(),'errorCode'=>10000,'code'=>400]);
        }
        return true;
    }

    protected function isPefectCode($value, $rule='', $data='', $field='')
    {
        // 验证码不存在
        $beforeCode = cache($data['phone']);
        if (!$beforeCode) {
            return "请重新获取验证码";
        }
        // 验证验证码
        if ($value != $beforeCode) {
            return "验证码错误";
        }
        return true;
    }
    // 话题是否存在
    protected function isTopicExist($value, $rule='', $data='', $field='')
    {
        if ($value==0) {
            return true;
        }
        if (\app\common\model\Topic::field('id')->find($value)) {
            return true;
        }
        return "该话题已不存在";
    }

    // 文章分类是否存在
    protected function isPostClassExist($value, $rule='', $data='', $field='')
    {
        if (\app\common\model\PostClass::field('id')->find($value)) {
            return true;
        }
        return "该文章分类已不存在";
    }
}
