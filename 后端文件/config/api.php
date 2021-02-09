<?php
return [
    //阿里大于
        'aliSMS'=>[
            'isopen'=>false,//开启阿里大于
            'accessKeyId'=>'<accessKeyId>',
            'accessSecret'=>'<accessSecret>',
            'regionID'=>'cn-hangzhou',
            'product'=>'Dysmsapi',
            'version'=>'2017-05-25',
            'SignName'=>'<YourSignNane>',
            'TemplateCode'=>'<YourTemplateCode>',
            //验证码有效期
            'expire'=>60,
            'token_expire'=>0,
        ]
];