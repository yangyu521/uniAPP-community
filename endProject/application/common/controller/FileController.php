<?php

namespace app\common\controller;

use think\Controller;
use think\Request;

class FileController extends Controller
{
 // 上传单文件
 static public function UploadEvent($files,$size = '2067800',$ext = 'jpg,png,gif',$path = 'uploads')
 {
     $info = $files->validate(['size'=>$size,'ext'=>$ext])->move($path);
     return [
         'data'=> $info ? $info->getPathname() : $files->getError(),
         'status'=> $info ? true :false
     ];
 }
}
