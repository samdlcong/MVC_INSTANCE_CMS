<?php

class VIEW {
	public static $view;

	public static function init($viewtype,$config){
		self::$view = new $viewtype;
		foreach($config as $k=>$v){
			self::$view->$k=$v;
		}
	}

	public static function assign($data){
		foreach($data as $k => $v){
			self::$view->assign($k,$v);
		}
	}

	public static function display($template){
		self::$view->display($template);
	}
}