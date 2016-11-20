<?php
return array(
    //'配置项'=>'配置值'
    'TMPL_PARSE_STRING'     =>  array(//布局模板替换标识
        '__CSS__'   => '/Public/css',
        '__JS__'   => '/Public/Js',
        '__IMG__'   => '/Public/Images',
        '__VALIDATE__'   => '/Public/ext/validate',
        '__LAYER__'   => '/Public/ext/layer',
    ),
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'project', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'shop_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
    'PAGE_MODE' =>[//分页配置
        'SIZE'=>2,
        'THEME'=>'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%',
    ],
    'RBAC'=>[
        'IGNORES'=>['Home/Member/login', 'Home/Captcha/show','Home/Member/regist'],//全局忽略列表
    ],
    'COOKIE_PREFIX'         =>  'Member_shop_com_',      // Cookie前缀 避免冲突
);