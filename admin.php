<?php

header('Content-type:text/html;charset=utf-8');
session_start();
require_once('config.php');
require_once('framework/pc.php');
PC::run($viewconfig);
//echo '初始化完毕';