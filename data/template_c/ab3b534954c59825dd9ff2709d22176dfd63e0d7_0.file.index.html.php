<?php
/* Smarty version 3.1.29, created on 2016-07-28 17:05:31
  from "E:\amp\apache\htdocs\blog\tpl\index\index.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5799cadba037a6_93405185',
  'file_dependency' => 
  array (
    'ab3b534954c59825dd9ff2709d22176dfd63e0d7' => 
    array (
      0 => 'E:\\amp\\apache\\htdocs\\blog\\tpl\\index\\index.html',
      1 => 1469696729,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5799cadba037a6_93405185 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>新闻乱播</title>
	<link rel="stylesheet" href="img/css/reset.css">
	<link rel="stylesheet" href="img/css/main.css">
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
				<?php
$_from = $_smarty_tpl->tpl_vars['data']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_news_0_saved_item = isset($_smarty_tpl->tpl_vars['news']) ? $_smarty_tpl->tpl_vars['news'] : false;
$_smarty_tpl->tpl_vars['news'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['news']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['news']->value) {
$_smarty_tpl->tpl_vars['news']->_loop = true;
$__foreach_news_0_saved_local_item = $_smarty_tpl->tpl_vars['news'];
?>
				<h2><a href="index.php?controller=index&method=newsshow&id=<?php echo $_smarty_tpl->tpl_vars['news']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['news']->value['title'];?>
</a></h2>
				<p class="meta"><?php echo $_smarty_tpl->tpl_vars['news']->value['author'];?>
发布于<?php echo $_smarty_tpl->tpl_vars['news']->value['dateline'];?>
</p>
				<p>
				<?php echo $_smarty_tpl->tpl_vars['news']->value['content'];?>
...more</p>
			<?php
$_smarty_tpl->tpl_vars['news'] = $__foreach_news_0_saved_local_item;
}
if ($__foreach_news_0_saved_item) {
$_smarty_tpl->tpl_vars['news'] = $__foreach_news_0_saved_item;
}
?>
			</div>
			
			<div class="about">
				<h3>关于我们</h3>
				<p><?php echo $_smarty_tpl->tpl_vars['about']->value;?>
</p>
			</div>
		</div>
	</div>
	
	<div class="footer">
		<div class="warp">
			
		</div>
	</div>
</body>
</html>

<?php }
}
