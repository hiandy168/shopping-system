<?php
return array(
	//'配置项'=>'配置值'
	//
	//模板常量
	'TMPL_PARSE_STRING' => array(
							'__ADMIN__' => __ROOT__.'/Public/Admin',
							'__HOME__' => __ROOT__.'/Public/Home',
							'__UPLOADS__'=>__ROOT__.'/Public/Admin/Uploads'
						),
	//页面底部设置显示跟踪信息
	'SHOW_PAGE_TRACE' => false,

	//设置默认分组
	// 'DEFAULT_MODULE' => 'Home',	//设置默认模块
	'MODULE_ALLOW_LIST' => array('Home','Admin'),	//设置一个用于对比的分组列表，用户就可以不输入分组了


	 /* 数据库设置 */
	'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'shopping',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'ss_',    // 数据库表前缀

	'URL_MODEL'             =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
	'TMPL_TEMPLATE_SUFFIX'  =>  '.html',     // 默认模板文件后缀
	'DEFAULT_FILTER'        =>  'trim,htmlspecialchars,addslashes',//默认I方法的过滤函数
);