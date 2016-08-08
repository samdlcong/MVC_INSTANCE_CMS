<?php
/* Smarty version 3.1.29, created on 2016-07-28 17:06:09
  from "E:\amp\apache\htdocs\blog\tpl\index\show.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5799cb011312d9_39992935',
  'file_dependency' => 
  array (
    '5ca635010e94de3de1d12bd427228bb51ae60a2a' => 
    array (
      0 => 'E:\\amp\\apache\\htdocs\\blog\\tpl\\index\\show.html',
      1 => 1469696765,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5799cb011312d9_39992935 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $_smarty_tpl->tpl_vars['data']->value['title'];?>
</title>
	<link rel="stylesheet" href="img/css/reset.css">
	<link rel="stylesheet" href="img/css/article.css">
</head>
<body>
	<div class="nav">
		<div class="wrap">
			<ul>
				<li><a href="index.php">新闻首页</a></li>
				<li><a href="#">关于我们</a></li>
			</ul>
		</div>
	</div>
	<div class="banner">
		<div class="wrap">
			<h1>新闻发布系统</h1>
			<p>这是一个新闻发布的MVC案例</p>
		</div>
	</div>
	<div class="content">
		<div class="wrap">

			<div class="article">
				
				<h2><?php echo $_smarty_tpl->tpl_vars['data']->value['title'];?>
</a></h2>
				<p class="meta"><?php echo $_smarty_tpl->tpl_vars['data']->value['author'];?>
发布于<?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['data']->value['dateline']);?>
</p>
				<p>
				<?php echo $_smarty_tpl->tpl_vars['data']->value['content'];?>
</p>
			</div>
		</div>
	</div>
	
	<div class="footer">
		<div class="warp">
			
		</div>
	</div>
</body>
</html><?php }
}
