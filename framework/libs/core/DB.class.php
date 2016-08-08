<?php

class DB{
	protected static $db= null;

	public static function init($dbtype){
		return self::$db = $dbtype::getInstance();
	}

	public static function query($sql){
		return self::$db->query($sql);
	}

	public static function getAll($sql){
		return self::$db->getAll($sql);
	}

	public static function getRow($sql){
		return self::$db->getRow($sql);
	}

	public static function findById($table,$id,$fields="*"){
		return self::$db->findById($table,$id,$fields);
	}

	public static function find($table,$where=null,$fields="*",$group=null,$having=null,$order=null,$limit=null){
		return self::$db->find($table,$where,$fields,$group,$having,$order,$limit);
	}

	public static function add($table,$data){
		return self::$db->add($table,$data);
	}

	public static function update($table,$data,$where=null,$order=null,$limit=null){
		return self::$db->update($table,$data,$where,$order,$limit);
	}

	public static function delete($table,$where=null,$order=null,$limit=null){
		return self::$db->delete($table,$where,$order,$limit);
	}

	public static function execute($sql=null){
		return self::$db->execute($sql);
	}

	public static function getLastInsertId(){
		return self::getLastInsertId();
	}

	public static function getDbVersion(){
		return self::getDbVersion();
	}

	public static function showTables(){
		return self::showTables();
	}

	public static function close(){
		return self::$db->close();
	}
}


// require_once('DbMysqli.class.php');
// require_once('config2.php');
// $db = DB::init('DbMysqli');
// $db2 = DB::init('DbMysqli');
// print_r($db);
// print_r($db2);
//$sql ='select * from test1';
//print_r($db->getAll($sql));