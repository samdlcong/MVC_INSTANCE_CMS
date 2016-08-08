<?php
$currentdir = dirname(__FILE__);
include_once($currentdir.'/include.list.php');
foreach($paths as $path){
	include_once($currentdir.'/'.$path);
}

class PC {
	public static $controller;
	public static $method;
	private static $config=array();
	private static function init_db(){
		DB::init('DbMysqli');
	}

	private static function init_view(){
		VIEW::init('Smarty',self::$config);	
	}

	private static function init_controllor(){
		self::$controller = isset($_GET['controller'])?daddslashes($_GET['controller']):'index';
	}

	private static function init_method(){
		self::$method = isset($_GET['method'])?daddslashes($_GET['method']):'index';
	}

	public static function run($config){
		self::$config = $config;
		self::init_db();
		self::init_view();
		self::init_controllor();
		self::init_method();
		C(self::$controller,self::$method);
	}
}

