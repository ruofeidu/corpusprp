<?php
// +----------------------------------------------------------------------
// | Corpus [ Contrive optimistic recognition passion supremely ultimately]
// +----------------------------------------------------------------------
// | Copyright (c) 2011 Corpus PRP Group Under Prof. Zhang
// +----------------------------------------------------------------------
// | Author: Du Ruofei, Yao Enpeng, Chen Bo @ PRP Group
// +----------------------------------------------------------------------
// | Contact: xiaoxinghai [at] gmail.com
// +----------------------------------------------------------------------

class PublicAction extends Action {
	// 检查用户是否登录

	protected function checkUser() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			$this->assign('jumpUrl','Public/login');
			$this->error(L('no_login'));
		}
	}

	// 顶部页面
	public function top() {
		C('SHOW_RUN_TIME',false);			// 运行时间显示
		C('SHOW_PAGE_TRACE',false);
		$model	=	M("Group");
		$list	=	$model->where('status=1')->getField('id,title');
		$this->assign('nodeGroupList',$list);
		$this->display();
	}
	// 尾部页面
	public function footer() {
		C('SHOW_RUN_TIME',false);			// 运行时间显示
		C('SHOW_PAGE_TRACE',false);
		$this->display();
	}
	// 菜单页面
	public function menu() {
        $this->checkUser();
        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
            //显示菜单项
            $menu  = array();
            if(isset($_SESSION['menu'.$_SESSION[C('USER_AUTH_KEY')]])) {

                //如果已经缓存，直接读取缓存
                $menu   =   $_SESSION['menu'.$_SESSION[C('USER_AUTH_KEY')]];
            }else {
                //读取数据库模块列表生成菜单项
                $node    =   M("Node");
				$id	=	$node->getField("id");
				$where['level']=2;
				$where['status']=1;
				$where['pid']=$id;
                $list	=	$node->where($where)->field('id,name,group_id,title')->order('sort asc')->select();
                $accessList = $_SESSION['_ACCESS_LIST'];
                foreach($list as $key=>$module) {
                     if(isset($accessList[strtoupper(APP_NAME)][strtoupper($module['name'])]) || $_SESSION['corpusAdmin']) {
                        //设置模块访问权限
                        $module['access'] =   1;
                        $menu[$key]  = $module;
                    }
                }
                //缓存菜单访问
                $_SESSION['menu'.$_SESSION[C('USER_AUTH_KEY')]]	=	$menu;
            }
            if(!empty($_GET['tag'])){
                $this->assign('menuTag',$_GET['tag']);
            }
			//dump($menu);
            $this->assign('menu',$menu);
		}
		C('SHOW_RUN_TIME',false);			// 运行时间显示
		C('SHOW_PAGE_TRACE',false);
		$this->display();
	}

    // 后台首页 查看系统信息
    public function main() {
        $info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式'=>php_sapi_name(),
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '剩余空间'=>round((@disk_free_space(".")/(1024*1024)),2).'M',
            'register_globals'=>get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
            'magic_quotes_gpc'=>(1===get_magic_quotes_gpc())?'YES':'NO',
            'magic_quotes_runtime'=>(1===get_magic_quotes_runtime())?'YES':'NO',
            );
        $this->assign('info',$info);
        $this->display();
    }

	// 用户登录页面
	public function login() {
		if (!isset($_SESSION[C('USER_AUTH_KEY')])) {
			$News = M('form'); 
			$a = $News->getById(1); 
			$this->assign("news", $a);
			$this->display();
		}
		else{
			if ($_SESSION[C('corpusAdmin')] ){
				$this->redirect('Index/index');
			} else {
				$this->redirect('Search/index');
			}
		}
	}
	
	public function news(){
		$News = M('form'); 
		$a = $News->getById(1); 
		$this->assign("news", $a);
		$this->display();
	}

	public function index()
	{	
		redirect(__APP__);
	}

	// 用户登出
    public function logout()
    {
        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
			unset($_SESSION[C('USER_AUTH_KEY')]);
			unset($_SESSION);
			session_destroy();
            $this->assign("jumpUrl",__URL__.'/login/');
            $this->success(L('log_out_success'));
        }else {
            $this->error(L('log_out_already'));
        }
    }

	// 登录检测
	public function checkLogin() {
		if(empty($_POST['account'])) {
			$this->error(L('account_wrong'));
		}elseif (empty($_POST['password'])){
			$this->error(L('password_must'));
		}elseif (empty($_POST['verify'])){
			$this->error(L('code_must'));
		}
        //生成认证条件
        $map            =   array();
		// 支持使用绑定帐号登录
		$map['account']	= $_POST['account'];
        $map["status"]	=	array('gt',0);
		if($_SESSION['verify'] != md5($_POST['verify'])) {
			$this->error(L('code_wrong'));
		}
		import ( '@.ORG.RBAC' );
        $authInfo = RBAC::authenticate($map);
        //使用用户名、密码和状态的方式进行认证
        if(false === $authInfo) {
            $this->error(L('account_no_exist'));
        }else {
            if($authInfo['password'] != md5($_POST['password'])) {
            	$this->error(L('password_wrong'));
            }
            $_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];
            $_SESSION['email']				=	$authInfo['email'];
            $_SESSION['loginUserName']		=	$authInfo['nickname'];
            $_SESSION['lastLoginTime']		=	$authInfo['last_login_time'];
			$_SESSION['login_count']		=	$authInfo['login_count'];
            if ($authInfo['account'] == 'admin') {
            	$_SESSION['corpusAdmin']	=	true;
				$_SESSION['_ACCESS_LIST']['CORPUS']['INDEX']['MAIN'] = '50';
            }
            //保存登录信息
			$User							=	M('User');
			$ip								=	get_client_ip();
			$time							=	time();
            $data 							=	array();
			$data['id']						=	$authInfo['id'];
			$data['last_login_time']		=	$time;
			$data['login_count']			=	array('exp','login_count+1');
			$data['last_login_ip']			=	$ip;
			$User->save($data);

			// 缓存访问权限
            RBAC::saveAccessList();
			$this->success(L('log_in_success'));
		}
	}
    // 更换密码
    public function changePwd()
    {
		$this->checkUser();
        //对表单提交处理进行处理或者增加非表单数据
		if (md5($_POST['verify'])	!= $_SESSION['verify']) {
			$this->error(L('code_wrong'));
		}
		$map	=	array();
        $map['password']= pwdHash($_POST['oldpassword']);
        if(isset($_POST['account'])) {
            $map['account']	 =	 $_POST['account'];
        }elseif(isset($_SESSION[C('USER_AUTH_KEY')])) {
            $map['id']		=	$_SESSION[C('USER_AUTH_KEY')];
        }
        //检查用户
        $User    =   M("User");
        if(!$User->where($map)->field('id')->find()) {
            $this->error(L('password_error'));
        }else {
			$User->password		=	pwdHash($_POST['password']);
			$User->save();
			$this->success(L('password_success'));
         }
    }
public function profile() {
		$this->checkUser();
		$User	 =	 M("User");
		$vo	=	$User->getById($_SESSION[C('USER_AUTH_KEY')]);
		$this->assign('vo',$vo);
		$this->display();
	}
	 public function verify()
    {
		$type	 =	 isset($_GET['type'])?$_GET['type']:'gif';
        import("@.ORG.Image");
        Image::buildImageVerify(4,1,$type);
    }
// 修改资料
	public function change() {
		$this->checkUser();
		$User	 =	 D("User");
		if(!$User->create()) {
			$this->error($User->getError());
		}
		$result	=	$User->save();
		if(false !== $result) {
			$this->success(L('profile_success'));
		}else{
			$this->error(('profile_fail'));
		}
	}
}
?>