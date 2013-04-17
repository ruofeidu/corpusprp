<?php
return array(
	//'������'=>'����ֵ'
	'APP_DEBUG'				=>	false, 			// ��������ģʽ 
    'TMPL_SWITCH_ON'		=>	true,	// ���ö�ģ��֧��
	'TMPL_DETECT_THEME'     => true,      // �Զ����ģ������
	'LANG_SWITCH_ON' 		=>	true,			// ����������֧��
    'LANG_AUTO_DETECT'  	=>  true,    	 	// �Զ��������
	'LANG_LIST'				=>	'zh-cn,ja-jp',  // ����д������������б�
	'DEFAULT_LANG'			=>  'zh-cn',     	// ��ĿĬ������Ϊ���� 
	'URL_MODEL'		=>	1,
	'DB_TYPE'		=>	'mysql', 		// ���ݿ�����
	'DB_HOST'		=>	'127.0.0.1', 	// ���ݿ��������ַ
	'DB_NAME'		=>	'corpus', 		// ���ݿ����� 
	'DB_USER'		=>	'root', 		// ���ݿ��û��� 
	'DB_PWD'		=>	'',				// ���ݿ����� 
	'DB_PORT'		=>	'3306', 		// ���ݿ�˿�  
	'DB_PREFIX'		=>	'corpus_', 		// ���ݱ�ǰ׺
	
	'USER_AUTH_ON'			=>	true,
	'USER_AUTH_TYPE'		=>	1,				// Ĭ����֤���� 1 ��¼��֤ 2 ʵʱ��֤
	'USER_AUTH_KEY'			=>	'corpusUser',	// �û���֤SESSION���
    'ADMIN_AUTH_KEY'		=>	'corpusAdmin',	// ����Ա��֤SESSION��ǣ������� PublicAction ͬ��������BUG����֪Ϊ�Σ����Ҳ�����ADMIN_AUTH_KEY���档
	'USER_AUTH_MODEL'		=>	'User',			// Ĭ����֤���ݱ�ģ��
	'AUTH_PWD_ENCODER'		=>	'md5',			// �û���֤������ܷ�ʽ
	'USER_AUTH_GATEWAY'		=>	'/Public/login',// Ĭ����֤����
	'NOT_AUTH_MODULE'		=>	'Public',		// Ĭ��������֤ģ��
	'REQUIRE_AUTH_MODULE'	=>	'',				// Ĭ����Ҫ��֤ģ��
	'NOT_AUTH_ACTION'		=>	'',				// Ĭ��������֤����
	'REQUIRE_AUTH_ACTION'	=>	'',				// Ĭ����Ҫ��֤����
    'GUEST_AUTH_ON'			=>	false,    		// �Ƿ����ο���Ȩ����
    'GUEST_AUTH_ID'         =>	0,     			// �ο͵��û�ID
	
	'SHOW_RUN_TIME'			=>	true,			// ����ʱ����ʾ
	'SHOW_ADV_TIME'			=>	true,			// ��ʾ��ϸ������ʱ��
	'SHOW_DB_TIMES'			=>	true,			// ��ʾ���ݿ��ѯ��д�����
	'SHOW_CACHE_TIMES'		=>	true,			// ��ʾ�����������
	'SHOW_USE_MEM'			=>	true,			// ��ʾ�ڴ濪��
	
    'DB_LIKE_FIELDS'		=>	'title|remark',
	
	'RBAC_ROLE_TABLE'		=>	'corpus_role',
	'RBAC_USER_TABLE'		=>	'corpus_role_user',
	'RBAC_ACCESS_TABLE'		=>	'corpus_access',
	'RBAC_NODE_TABLE'		=>  'corpus_node',
);
?>
