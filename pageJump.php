<?php
	session_start();
	header('Expires:-1'); 
	header('Cache-Control:');
	header('Pragma:');
        header('Content-type: text/html; charset=Shift_JIS'); 
	require_once("f_Construct.php");
	startJump($_POST);

	session_regenerate_id();
	$name = $_SESSION['userName'];
	$_SESSION = array();
	$_SESSION['userName'] = $name;
	$_SESSION['pre_post'] = $_POST;
	$_SESSION['files'] = $_FILES;
	$keyarray = array_keys($_POST);
	$url = 'retry';
	foreach($keyarray as $key)
	{
		if (strstr($key, '_button') != false )
		{
			$pre_url = explode('_',$key);
			if($pre_url[1] == 1)
			{
				$url = 'insert';
				$_SESSION['filename'] = $pre_url[0]."_".$pre_url[1];
			}
			else if($pre_url[1] == 2)
			{
				$url = 'list';
				$_SESSION['filename'] = $pre_url[0]."_".$pre_url[1];
			}
			else if($pre_url[1] == 3)
			{
				$url = 'edit';
				$_SESSION['filename'] = $pre_url[0]."_".$pre_url[1];
			}
			else if($pre_url[1] == 4)
			{
				$url = 'mainmenu';
				$_SESSION['filename'] = $pre_url[0]."_".$pre_url[1];
			}
			else if($pre_url[1] == 5)
			{
				$url = $pre_url[0];
				$_SESSION['filename'] = $pre_url[0]."_".$pre_url[1];
			}
			else if($pre_url[1] == 'MENU')
			{
				$url = 'mainmenu';
				$_SESSION['filename'] = $pre_url[0]."_".$pre_url[1];
			}
			else if($pre_url[1] == 'MENTEMENU')
			{
				$url = 'mentemenu';
				$_SESSION['filename'] = $pre_url[0]."_".$pre_url[1];
			}
			else if($pre_url[1] == '')
			{
				$url = 'login';
				$_SESSION['filename'] = $pre_url[0]."_".$pre_url[1];
			}
			else
			{
				$url = $pre_url[0];
			}
		} 
	}
	
	header("location:".(empty($_SERVER['HTTPS'])? "http://" : "https://")
			.$_SERVER['HTTP_HOST'].dirname($_SERVER["REQUEST_URI"])."/".$url.".php");
//	echo '<script type="text/javascript">';
//	echo "<!--\n";
//	echo 'location.href = "./'.$url.'.php";';
//	echo '// -->';
//	echo '</script>';
?>

<!DOCTYPE html PUBLIC "-//W3C/DTD HTML 4.01">
<!-- saved from url(0013)about:internet -->
<!-- 
*------------------------------------------------------------------------------------------------------------*
*                                                                                                            *
*                                                                                                            *
*                                          ver 1.0.0  2014/05/09                                             *
*                                                                                                            *
*                                                                                                            *
*------------------------------------------------------------------------------------------------------------*
 -->

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<script language="JavaScript"><!--
	history.forward();
--></script>
</head>
<body>
</body>
</html>
