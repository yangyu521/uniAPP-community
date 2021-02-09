<?php

namespace app\api\controller\v1;

use app\common\model\Topic as TopicModel;
use app\common\controller\BaseController;
use app\common\validate\TopicClassValidate;
use think\Controller;
use think\Request;

class Topic extends BaseController
{
    // 获取10个话题
    public function index()
    {
        $list = (new TopicModel())->gethotlist();
        return self::showResCode('获取成功', ['list'=>$list]);
    }
    // 获取指定话题分类下的话题列表
    public function topic()
    {
        // 验证分类id和分页数
        (new TopicClassValidate())->goCheck();

        $list=(new TopicClassModel)->getTopic();
        return self::showResCode('获取成功', ['list'=>$list]);
    }
    // 获取指定话题下的文章列表
    public function post()
    {
        (new TopicClassValidate())->goCheck();
        $list=(new TopicModel)->getPost();
        return self::showResCode('获取成功', ['list'=>$list]);
    }
}
