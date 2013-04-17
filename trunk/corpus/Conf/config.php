<?php
return array(
	//'配置项'=>'配置值'
	'APP_DEBUG'				=>	false, 			// 开启调试模式 
    'TMPL_SWITCH_ON'		=>	true,	// 启用多模版支持
	'TMPL_DETECT_THEME'     => true,      // 自动侦测模板主题
	'LANG_SWITCH_ON' 		=>	true,			// 启动多语言支持
    'LANG_AUTO_DETECT'  	=>  true,    	 	// 自动侦测语言
	'LANG_LIST'				=>	'zh-cn,ja-jp',  // 必须写可允许的语言列表
	'DEFAULT_LANG'			=>  'zh-cn',     	// 项目默认语言为汉语 
	'URL_MODEL'		=>	1,
	'DB_TYPE'		=>	'mysql', 		// 数据库类型
	'DB_HOST'		=>	'127.0.0.1', 	// 数据库服务器地址
	'DB_NAME'		=>	'corpus', 		// 数据库名称 
	'DB_USER'		=>	'root', 		// 数据库用户名 
	'DB_PWD'		=>	'',				// 数据库密码 
	'DB_PORT'		=>	'3306', 		// 数据库端口  
	'DB_PREFIX'		=>	'corpus_', 		// 数据表前缀
	
	'USER_AUTH_ON'			=>	true,
	'USER_AUTH_TYPE'		=>	1,				// 默认认证类型 1 登录认证 2 实时认证
	'USER_AUTH_KEY'			=>	'corpusUser',	// 用户认证SESSION标记
    'ADMIN_AUTH_KEY'		=>	'corpusAdmin',	// 管理员认证SESSION标记，必须与 PublicAction 同步，否则BUG，不知为何，而且不能用ADMIN_AUTH_KEY代替。
	'USER_AUTH_MODEL'		=>	'User',			// 默认验证数据表模型
	'AUTH_PWD_ENCODER'		=>	'md5',			// 用户认证密码加密方式
	'USER_AUTH_GATEWAY'		=>	'/Public/login',// 默认认证网关
	'NOT_AUTH_MODULE'		=>	'Public',		// 默认无需认证模块
	'REQUIRE_AUTH_MODULE'	=>	'',				// 默认需要认证模块
	'NOT_AUTH_ACTION'		=>	'',				// 默认无需认证操作
	'REQUIRE_AUTH_ACTION'	=>	'',				// 默认需要认证操作
    'GUEST_AUTH_ON'			=>	false,    		// 是否开启游客授权访问
    'GUEST_AUTH_ID'         =>	0,     			// 游客的用户ID
	
	'SHOW_RUN_TIME'			=>	true,			// 运行时间显示
	'SHOW_ADV_TIME'			=>	true,			// 显示详细的运行时间
	'SHOW_DB_TIMES'			=>	true,			// 显示数据库查询和写入次数
	'SHOW_CACHE_TIMES'		=>	true,			// 显示缓存操作次数
	'SHOW_USE_MEM'			=>	true,			// 显示内存开销
	
    'DB_LIKE_FIELDS'		=>	'title|remark',
	
	'RBAC_ROLE_TABLE'		=>	'corpus_role',
	'RBAC_USER_TABLE'		=>	'corpus_role_user',
	'RBAC_ACCESS_TABLE'		=>	'corpus_access',
	'RBAC_NODE_TABLE'		=>  'corpus_node',
);
?>
