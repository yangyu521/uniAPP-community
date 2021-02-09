<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use app\common\controller\BaseController;
use app\common\validate\SearchValidate;
use app\common\model\Topic as TopicModel;

class Search extends BaseController
{
    // 搜索话题
    public function topic()
    {
        (new SearchValidate())->goCheck();
        $list = (new TopicModel())->Search();
        return self::showResCode('获取成功', ['list'=>$list]);
    }
}
