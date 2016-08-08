<?php
	function C($name,$method){
		require_once('/libs/Controller/'.$name.'Controller.class.php');
		$controller = $name.'Controller';
		//echo $controller;
		$control = new $controller();
		//$method = $method.'()';
		//echo $method;
		//return $method;
		$control->$method();
	}

	function M($name){
		require_once('/libs/Model/'.$name.'Model.class.php');
		$model =$name.'Model';
		return new $model();
	}

	function V($name){
		require_once('/libs/View/'.$name.'View.class.php');
		$view = $name.'View';
		return new $view();
	}

	function ORG($path,$name,$params=array()){
		require_once('/libs/ORG/'.$path.$name.'.class.php');
		$obj = new $name();
		if(!empty($params)){
		foreach($params as $key=>$value){
				//eval('$obj->'.$key.' = \''.$value.'\';');
				$obj->$key = $value;
			}
		}
		return $obj;
	}

	function daddslashes($str){
		return (!get_magic_quotes_gpc())?addslashes($str):$str;
	}
