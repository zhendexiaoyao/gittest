<?php
return array(
	//'配置项'=>'配置值'
    'BASE_URL' =>'http://admin.shop.com/',
    'TMPL_PARSE_STRING'     =>  array(
        '__CSS__'   => '/Public/css',
        '__JS__'   => '/Public/Js',
        '__IMG__'   => '/Public/Images',
        '__UPLOADIFY__'   => '/Public/ext/uploadify',
        '__LAYER__'   => '/Public/ext/layer',
        '__UEDITOR__'   => '/Public/ext/ueditor',
        '__ZTREE__'=>'/Public/ext/ztree',
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
    'PAGE_MODE' =>[
        'SIZE'=>2,
        'THEME'=>'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%',
    ],
    'RBAC'=>[
        'IGNORES'=>['Admin/Admin/login', 'Admin/Admin/verify',],
        'IGNORANCE'=>[
            'Admin/Index/index',
            'Admin/Index/main',
            'Admin/Index/top',
            'Admin/Index/menu',
            'Admin/Upload/upload',
            'Admin/Admin/logout'
        ],
    ],
    'COOKIE_PREFIX'         =>  'admin_shop_com_',      // Cookie前缀 避免冲突
);