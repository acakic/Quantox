<?php 

class View
{
	public static $data = array();
	public static function load(string $folder, string $file)
	{
		require_once('./view/inc/header.php');
		require_once('./view/' . $folder . '/' . $file . '.php');
		require_once('./view/inc/footer.php');
	} 
}