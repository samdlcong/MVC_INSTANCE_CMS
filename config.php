<?php

//定义数据库配置
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PWD','123456');
define('DB_TYPE','mysql');
define('DB_NAME','blog');
define('DB_HOSTPORT','3306');
define('DB_CHARSET','utf-8');

//view层 smarty配置
$viewconfig = array(
	'left_delimiter'=>'{',
	'right_delimiter'=>'}',
	'template_dir'=>'tpl',
	'compile_dir'=>'data/template_c'
	);