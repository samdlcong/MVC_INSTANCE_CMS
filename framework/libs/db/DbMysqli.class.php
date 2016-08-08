<?php
header("content-type:text/html;charset=utf-8");
class DbMysqli{
	protected static $ins = null; //单例模式
	public static $config = array();//保存配置文件
	public static $conn = null;//保存连接标识符
	public static $connected = false; //保存连接状态
	public static $dbVersion = '';//保存数据库版本号
	public static $result = null;//保存结果集
	public static $sqlStr = '';//保存最近一次执行的sql语句
	public static $error = '';//保存错误信息
	public static $lastInsertId = '';//保存auto_increment的值
	public static $numRows = 0;//保存受影响记录条数
	//public  $de = null; //单例测试
	/**
	 * 初始化工作 连接数据库
	 * @param string $dbConfig [description]
	 */
	final protected function __construct($dbConfig=''){
		if(!class_exists("mysqli")){
			self::throwErrorException("请先开启mysqli库支持");
		}
		if(!is_array($dbConfig)){
			$dbConfig = array(
				'hostname'=>DB_HOST,
				'username'=>DB_USER,
				'password'=>DB_PWD,
				'dbname'=>DB_NAME,
				'dbport'=>DB_HOSTPORT,
				'dbtype'=>DB_TYPE
				);
		}
		if(empty($dbConfig['hostname'])) self::throwErrorException("请先配置数据库");
		self::$config = $dbConfig;
		if(!isset(self::$conn)){
			$configs = self::$config;
			$conn = new mysqli($configs['hostname'],$configs['username'],$configs['password'],$configs['dbname'],$configs['dbport']);
			if($conn->connect_errno){
				self::throwErrorException($conn->connect_error);
				return false;
				//exit();
			}
			$conn->set_charset(DB_CHARSET);
			self::$dbVersion = $conn->server_version;
			self::$conn = $conn;
			self::$connected = true;
			//$this->de=mt_rand(1,999999999);
			unset($configs);
		}
	}
	 public static function getInstance(){
	 	if(self::$ins instanceof self){
	 		return self::$ins;
	 	}
	 	self::$ins = new self();
	 	return self::$ins;
	 }

	/**
	 * 取出全部记录
	 * @param  [type] $sql [description]
	 * @return [type]      [description]
	 */
	public static function getAll($sql=null){
		if($sql!=null){
			self::query($sql);
		}
		$result = array();
		while($row = self::$result->fetch_assoc()){
			$result[]=$row;
		}
		return $result;
	}

	/**
	 * 取出一条记录
	 * @param  [type] $sql [description]
	 * @return [type]      [description]
	 */
	public static function getRow($sql=null){
		if($sql!=null){
			self::query($sql);
		}
		$result = self::$result->fetch_assoc();
		return $result;
	}


	/**
	 * 根据主键id查询返回查询结果
	 * @param  [type] $table  [description]
	 * @param  [type] $id     [description]
	 * @param  string $fields [description]
	 * @return [type]         [description]
	 */
	public static function findById($table,$id,$fields="*"){
		$sql="select %s from %s where id = %d";
		//print_r($sql);
		return self::getRow(sprintf($sql,self::parseFields($fields),$table,$id));
	}

	/**
	 * find查询语句
	 * @param  [type] $table  [description]
	 * @param  [type] $where  [description]
	 * @param  string $fields [description]
	 * @param  [type] $group  [description]
	 * @param  [type] $having [description]
	 * @param  [type] $order  [description]
	 * @param  [type] $limit  [description]
	 * @return [type]         [description]
	 */
	public static function find($table,$where=null,$fields="*",$group=null,$having=null,$order=null,$limit=null){
		$sql="select ".self::parseFields($fields)." from ".$table
			.self::parseWhere($where)
			.self::parseHaving($having)
			.self::parseOrder($order)
			.self::parseLimit($limit);
		//print_r($sql);exit();
		$res = self::getAll($sql);
		return count($res)==1?$res[0]:$res;
	}


	public static function add($table,$data){
		if(is_array($data)){
			$keys = array_keys($data);
			array_walk($keys, array('DbMysqli','addSpecialChar'));
			$keys=implode(',', $keys);
			$values = "'".join("','",array_values($data))."'";
			$sql="insert {$table}({$keys}) values({$values})";
			return self::execute($sql);
		}else{
			self::throwErrorException("请输入正确的数据格式");
			return false;
		}
		
	}

	public static function update($table,$data,$where=null,$order=null,$limit=null){
		$sets ='';
		if(is_array($data)){
			foreach ($data as $key => $value) {
				$key='`'.$key.'`';
				$sets .= $key."='".$value."',";
			}
			$sets = rtrim($sets,',');
			$sql="update {$table} set {$sets} ".self::parseWhere($where).self::parseOrder($order).self::parseLimit($limit);
			//print_r($sql);exit();
			return self::execute($sql);
		}else{
			self::throwErrorException("请输入正确的数据格式");
			return false;
		}
		 
	}

	public static function delete($table,$where=null,$order=null,$limit=null){
		$sql="delete from {$table} ".self::parseWhere($where).self::parseOrder($order).self::parseLimit($limit);
		return self::execute($sql);
	}

	/**
	 * 对字段特殊处理
	 * @param [type] &$value [description]
	 */
	public static function addSpecialChar(&$value){
		if($value==="*"||strpos($value, '.')!==false||strpos($value,'`')!==false){	
		}elseif(strpos($value,'`')===false){
			$value='`'.trim($value).'`';
		}
		return $value;
	}

	/**
	 * 解析fields字段
	 * @param  [type] $fields [description]
	 * @return [type]         [description]
	 */
	public static function parseFields($fields){
		if(is_array($fields)){
			array_walk($fields, array('DbMysqli','addSpecialChar'));
			$fieldsStr = implode(',', $fields);
		}elseif(is_string($fields)&&!empty($fields)){
			if(strpos($fields,'`')===false){
				$fields =explode(',', $fields);
				array_walk($fields, array('DbMysqli','addSpecialChar'));
				$fieldsStr = implode(',', $fields);
			}else{
				$fieldsStr = $fields;
			}
		}else{
			$fieldsStr = '*';
		}
		return $fieldsStr;
	}

	/**
	 * 解析where子句
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	public static function parseWhere($where){
		$whereStr ='';
		if(is_string($where)&&!empty($where)){
			$whereStr= " where ".$where;
		}
		return empty($whereStr)?'':$whereStr;
	}

	/**
	 * 解析group子句
	 * @param  [type] $group [description]
	 * @return [type]        [description]
	 */
	public static function parseGroup($group){
		$groupStr = '';
		if(is_array($group)&&!empty($group)){
			$groupStr = " group by ".explode(',', $group);
		}elseif(is_string($group)){
			$groupStr = " group by ".$group;
		}
		return empty($groupStr)?'':$groupStr;
	}

	/**
	 * 解析order子句
	 * @param  [type] $order [description]
	 * @return [type]        [description]
	 */
	public static function parseOrder($order){
		$orderStr = '';
		if(is_array($order)&&!empty($order)){
			$orderStr = " order by ".join(',',$order);
		}elseif(is_string($order)){
			$orderStr = " order by ".$order;
		}
		return empty($orderStr)?'':$orderStr;
	}

	/**
	 * 解析having子句
	 * @param  [type] $having [description]
	 * @return [type]         [description]
	 */
	public static function parseHaving($having){
		$havingStr = '';
		if(is_string($having)&&!empty($having)){
			$havingStr = " having ".$having;
		}
		return empty($havingStr)?'':$havingStr;
	}

	/**
	 * 解析limit子句
	 * @param  [type] $limit [description]
	 * @return [type]        [description]
	 */
	public static function parseLimit($limit){
		$limitStr='';
		if(is_array($limit)){
			if(count($limit)>1){
				$limitStr=" limit ".$limit[0].','.$limit[1];
			}else{
				$limitStr = " limit ".$limit[0];
			}
		}
		if(is_string($limit)&&!empty($limit)){
			$limitStr = " limit ".$limit;
		}
		return empty($limitStr)?'':$limitStr;
	}

	/**
	 * 增删改操作 返回受影响的条数
	 * @param  [type] $sql [description]
	 * @return [type]      [description]
	 */
	public static function execute($sql=null){
		$conn = self::$conn;
		if(!$conn) return false;
		if(!empty(self::$result)) self::free();
		if($sql!=null){
			self::$sqlStr = $sql;
			if($res=$conn->query($sql)){
				self::$lastInsertId = $conn->insert_id;
				self::$numRows = $conn->affected_rows;
				return self::$numRows;
			}else{
				self::havingErrorException();
				return false;
			}
		}
	}

	/**
	 * 封装query方法
	 * @param  string $sql [description]
	 * @return [type]      [description]
	 */
	public static function query($sql=''){
		$conn = self::$conn;
		if(!$conn) return false;
		if(!empty(self::$result)) self::free();
		if($sql!=null){
			self::$sqlStr =$sql;
			if(self::$result = $conn->query($sql)){
				return self::$result;

			}else{
				self::havingErrorException();
				return false;
			}
		}
	}

	public static function getLastInsertId(){
		if(!self::$conn) return false;
		return self::$lastInsertId;
	}

	public static function getDbVersion(){
		if(!self::$conn) return false;
		return self::$dbVersion;
	}

	public static function showTables(){
		$conn=self::$conn;
		if(!$conn) return false;
		$tables =array();
		if(self::query("show tables")){
			$res = self::getAll();
			foreach ($res as $key => $value) {
				$tables[$key] = current($value);
			}
		}
		return $tables;
	}

	/**
	 * 释放结果集
	 * @return [type] [description]
	 */
	public static function free(){
		self::$result=null;
	}

	/**
	 * 自定义错误处理
	 * @param  [type] $errMsg [description]
	 * @return [type]         [description]
	 */
	public static function throwErrorException($errMsg){
		echo $errMsg;
	}

	/**
	 * 自定义错误信息
	 * @return [type] [description]
	 */
	public static function havingErrorException(){
		$conn = self::$conn;
		if($conn->errno!=0){
			self::$error = "SQLSTATE: ".$conn->errno."SQLERROR: ".$conn->error.'<br/>ERROR SQL: '.self::$sqlStr;
			self::throwErrorException(self::$error);
			return false;
		}
		//这里不会显示错误 TODO
		if(self::$sqlStr==''){
			self::throwErrorException("没有可以执行的sql语句");
			return false;
		}
	}

	/**
	 * 销毁对象 关闭数据库
	 * @return [type] [description]
	 */
	public static function close() {
		self::$conn = null;
	}
}


// require_once('config2.php');
// // $mysqli = new DbMysqli();
// // var_dump($mysqli);
// $db = DbMysqli::getInstance();
// $db2 = DbMysqli::getInstance();
// var_dump($db);
// var_dump($db2);


// //$sql=" ";
// //var_dump($mysqli::$sqlStr);
// //print_r($mysqli->getRow($sql));
// // $res = $mysqli->getAll($sql);
// // foreach ($res as $key => $value) {
// // 	echo $value['id'],$value['username'],'<br/>';
// // }
// //$sql="update test1 set age=20 where id >21";
// //$sql="delete from test1 where id=23";
// //$sql="insert test1(username,password,age) values('zzzz','zd@126.com',34)";
// //print_r($mysqli->execute($sql));
// //echo $mysqli::$lastInsertId;
// print_r($mysqli->findById('test1',28,'username,password'));
// print_r($mysqli->findById('test1',28,array('username','password')));
// print_r($mysqli->find('test1','id>5','username,age',null,null,null,'3'));
// print_r($mysqli->add('test1',array("username"=>'hhhhh','password'=>'233333','age'=>'33')));
// print_r($mysqli->delete('test1','id=2'));
// print_r($mysqli->update('test1',array('age'=>18),'id>27',null,'2'));
// print_r($mysqli->showTables());