<?php 
	define('THINK_PATH', './ThinkPHP');
	define('__ROOT__', '/corpus');  
	define('APP_NAME', 'corpus'); 
	define('APP_PATH', './corpus');
	require(THINK_PATH."/ThinkPHP.php");
	session_start();
	App::run(); 
?>
