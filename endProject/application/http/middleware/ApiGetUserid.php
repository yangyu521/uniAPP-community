<?php

namespace app\http\middleware;

class ApiGetUserid
{
    public function handle($request, \Closure $next)
    {     // 获取头部信息
        $param = $request->header();
        
        if (array_key_exists('token', $param)) {
            // 当前用户token是否存在（是否登录）
            $token = $param['token'];
            $user = \Cache::get($token);
            if ($user) {
                $request->userId = array_key_exists('type', $user) ? $user['user_id'] : $user['id'];
            }
        }
       
        return $next($request);
    }
}
