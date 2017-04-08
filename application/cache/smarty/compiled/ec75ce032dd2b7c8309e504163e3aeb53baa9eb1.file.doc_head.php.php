<?php /* Smarty version Smarty-3.1.1, created on 2013-06-27 07:33:22
         compiled from "application/views/templates/doc_head.php" */ ?>
<?php /*%%SmartyHeaderCode:4536945334f25bcc67e80a2-84203928%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ec75ce032dd2b7c8309e504163e3aeb53baa9eb1' => 
    array (
      0 => 'application/views/templates/doc_head.php',
      1 => 1372332677,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4536945334f25bcc67e80a2-84203928',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f25bcc681917',
  'variables' => 
  array (
    'reset_css' => 0,
    'grid_css' => 0,
    'template_css' => 0,
    'theme_css' => 0,
    'ui_theme_css' => 0,
    'css' => 0,
    'prototype_js' => 0,
    'base_class_js' => 0,
    'js_vars' => 0,
    'scripts' => 0,
    'title' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f25bcc681917')) {function content_4f25bcc681917($_smarty_tpl) {?><!DOCTYPE html>
<html lang="">
<head>
	<meta http-equiv="content-type" content="text/html; charset=">
	<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['reset_css']->value;?>
" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['grid_css']->value;?>
" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['template_css']->value;?>
" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_css']->value;?>
" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['ui_theme_css']->value;?>
" type="text/css" media="screen" />
<!-- Dynamically assigned stylesheets from module controller -->
<?php echo $_smarty_tpl->tpl_vars['css']->value;?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['prototype_js']->value;?>
"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['base_class_js']->value;?>
"></script>
<!-- Dynamically assigned scripts from module controller -->
<script type="text/javascript">
<?php echo $_smarty_tpl->tpl_vars['js_vars']->value;?>

</script>
<?php echo $_smarty_tpl->tpl_vars['scripts']->value;?>

	<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
</head>
<body>
<?php }} ?>