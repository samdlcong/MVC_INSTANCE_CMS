<?php

class adminController{
	public $auth = '';
	public function __construct(){
		$authobj = M('auth');
		$this->auth = $authobj->getauth();
		//echo var_dump($this->auth);
		if(empty($this->auth)&&(PC::$method!='login')){
			$this->showmessage('请登录后再操作！','admin.php?controller=admin&method=login');
		}
	}


	public function test(){
		echo 'hello';
	}
	public function login(){
		if($_POST){
			$this->checklogin();
		}else{
			VIEW::display('admin/login.html');
		}
	}

	public function checklogin(){
		$authobj = M('auth');
		if($authobj->loginsubmit()){
			$this->showmessage('登入成功','admin.php?controller=admin&method=index');
		}else{
			$this->showmessage('登入失败','admin.php?controller=admin&method=login');
		}	
	}

	public function index(){
		$newsobj = M('news');
		$newsnum = $newsobj->count();
		print_r($newsnum);
		View::assign(array('newsnum'=>$newsnum));
		View::display('admin/index.html');
	}

	public function logout(){
		$authobj=M('auth');
		$authobj->logout();
		$this->showmessage('退出成功!','admin.php?controller=admin&method=login');
	}


	public function newsadd(){
		if(empty($_POST)){//没有post数据，就显示添加、修改界面
			//读取旧信息
			if(isset($_GET['id'])){
				$data = M('news')->getnewsinfo($_GET['id']);
			}else{
				$data = array();
			}
			VIEW::assign(array('data'=>$data));
			VIEW::display('admin/newsadd.html');
		}else{//进入添加、修改的处理程序
			$this->newssubmit($_POST);
			VIEW::display('admin/newsadd.html');
		}
	}


	private function newssubmit(){
		$newsobj = M('news');
		$result = $newsobj->newssubmit($_POST);
		switch ($result) {
			case 0:
				$this->showmessage('操作失败！','admin.php?controller=admin&method=newsadd&id='.$_POST['id']);
				break;
			case 1:
				$this->showmessage('添加成功！','admin.php?controller=admin&method=newslist');
				break;
			case 2:
				$this->showmessage('修改成功！','admin.php?controller=admin&method=newslist');
				break;
		}
	}
	
	public function newslist(){
		$newsobj = M('news');
		$data = $newsobj->getAll_orderby_dateline();
		VIEW::assign(array('data'=>$data));
		VIEW::display('admin/newslist.html');
	}

	public function newsdel(){
		if(intval($_GET['id'])){
			$newsobj=M("news");
			$newsobj->del_by_id(intval($_GET['id']));
			$this->showmessage('删除新闻成功！','admin.php?controller=admin&method=newslist');
		}
	}

	public function showmessage($info,$url){
		echo "<script>alert('$info');window.location.href='$url'</script>";
		exit;
	}



}